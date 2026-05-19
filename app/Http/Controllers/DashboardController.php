<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function getProgress($id_kegiatan) {
        $summary = DB::selectOne('
            SELECT 
                SUM(tk.target_sampel) as total_target,
                SUM(COALESCE(mp.capi_submit, 0)) as total_submit,
                SUM(COALESCE(mp.capi_approved, 0)) as total_approved
            FROM t_target_kegiatan tk
            LEFT JOIN t_monitoring_progress mp ON tk.id_target = mp.id_target
            WHERE tk.id_kegiatan = ?
        ', [$id_kegiatan]);

        $overallProgress = 0;
        if ($summary->total_target > 0) {
            $overallProgress = round((($summary->total_submit + $summary->total_approved) / $summary->total_target) * 100, 2);
        }

        $regional = DB::select('
            SELECT 
                k.id_kabkota, k.nama_kabkota,
                COALESCE(SUM(tk.target_sampel), 0) as target,
                COALESCE(SUM(mp.capi_submit), 0) as submit,
                COALESCE(SUM(mp.capi_approved), 0) as approved
            FROM m_kabkota k
            LEFT JOIN t_target_kegiatan tk ON k.id_kabkota = tk.id_kabkota AND tk.id_kegiatan = ?
            LEFT JOIN t_monitoring_progress mp ON tk.id_target = mp.id_target
            GROUP BY k.id_kabkota, k.nama_kabkota
            ORDER BY k.id_kabkota ASC
        ', [$id_kegiatan]);

        foreach ($regional as &$r) {
            $r->progress_percentage = $r->target > 0 ? round((($r->submit + $r->approved) / $r->target) * 100, 2) : 0;
        }

        return response()->json([
            'summary' => [
                'total_target' => $summary->total_target ?? 0,
                'total_submit' => $summary->total_submit ?? 0,
                'total_approved' => $summary->total_approved ?? 0,
                'overall_progress' => $overallProgress
            ],
            'regional' => $regional
        ]);
    }

    public function getProgressEdit($id_kegiatan) {
        $rows = DB::table('t_target_kegiatan as tk')
            ->join('m_kabkota as kk', 'tk.id_kabkota', '=', 'kk.id_kabkota')
            ->join('t_monitoring_progress as mp', 'tk.id_target', '=', 'mp.id_target')
            ->where('tk.id_kegiatan', $id_kegiatan)
            ->select('mp.id_progress', 'kk.nama_kabkota', 'tk.id_kabkota', 'tk.target_sampel', 'mp.capi_open', 'mp.capi_submit', 'mp.capi_rejected', 'mp.capi_approved', 'mp.papi_belum_dicacah', 'mp.papi_dicacah', 'mp.papi_diolah')
            ->orderBy('kk.id_kabkota', 'asc')
            ->get();
        return response()->json($rows);

    }

    public function updateProgress(Request $request, $id_progress) {
        $data = [
            'updated_by' => 1, // Fallback or current user
            'tanggal_update' => DB::raw('CURRENT_TIMESTAMP')
        ];

        if ($request->has('capi_open')) $data['capi_open'] = $request->capi_open;
        if ($request->has('capi_submit')) $data['capi_submit'] = $request->capi_submit;
        if ($request->has('capi_rejected')) $data['capi_rejected'] = $request->capi_rejected;
        if ($request->has('capi_approved')) $data['capi_approved'] = $request->capi_approved;
        if ($request->has('papi_belum_dicacah')) $data['papi_belum_dicacah'] = $request->papi_belum_dicacah;
        if ($request->has('papi_dicacah')) $data['papi_dicacah'] = $request->papi_dicacah;
        if ($request->has('papi_diolah')) $data['papi_diolah'] = $request->papi_diolah;

        DB::table('t_monitoring_progress')
            ->where('id_progress', $id_progress)
            ->update($data);

        // Recalculate progress to store in history
        $progress = DB::table('t_monitoring_progress as mp')
            ->join('t_target_kegiatan as tk', 'mp.id_target', '=', 'tk.id_target')
            ->where('mp.id_progress', $id_progress)
            ->select('tk.id_kegiatan', 'tk.id_kabkota')
            ->first();

        if ($progress) {
            $id_kegiatan = $progress->id_kegiatan;
            $id_kabkota_updated = $progress->id_kabkota;

            // Get total submit & approved for the whole kegiatan (Provinsi)
            $totalProv = DB::table('t_target_kegiatan as tk')
                ->join('t_monitoring_progress as mp', 'tk.id_target', '=', 'mp.id_target')
                ->where('tk.id_kegiatan', $id_kegiatan)
                ->select(
                    DB::raw('SUM(COALESCE(mp.capi_submit, 0)) as total_submit'),
                    DB::raw('SUM(COALESCE(mp.capi_approved, 0)) as total_approved')
                )
                ->first();

            // Insert Provinsi Snapshot
            DB::table('t_progress_history')->insert([
                'id_kegiatan' => $id_kegiatan,
                'id_kabkota' => null,
                'capi_submit' => $totalProv->total_submit ?: 0,
                'capi_approved' => $totalProv->total_approved ?: 0,
                'tanggal_update' => DB::raw('CURRENT_TIMESTAMP')
            ]);

            // Get submit & approved for this specific KabKota
            $totalKK = DB::table('t_target_kegiatan as tk')
                ->join('t_monitoring_progress as mp', 'tk.id_target', '=', 'mp.id_target')
                ->where('tk.id_kegiatan', $id_kegiatan)
                ->where('tk.id_kabkota', $id_kabkota_updated)
                ->select(
                    DB::raw('SUM(COALESCE(mp.capi_submit, 0)) as kk_submit'),
                    DB::raw('SUM(COALESCE(mp.capi_approved, 0)) as kk_approved')
                )
                ->first();

            // Insert KabKota Snapshot
            DB::table('t_progress_history')->insert([
                'id_kegiatan' => $id_kegiatan,
                'id_kabkota' => $id_kabkota_updated,
                'capi_submit' => $totalKK->kk_submit ?: 0,
                'capi_approved' => $totalKK->kk_approved ?: 0,
                'tanggal_update' => DB::raw('CURRENT_TIMESTAMP')
            ]);
        }

        return response()->json(['message' => 'Progress berhasil diupdate']);
    }

    public function getHistory($id_kegiatan) {
        $history = DB::select('
            SELECT 
                h.id_history, h.id_kabkota, k.nama_kabkota, h.tanggal_update,
                CASE 
                    WHEN (SELECT SUM(tk.target_sampel) FROM t_target_kegiatan tk WHERE tk.id_kegiatan = h.id_kegiatan AND (tk.id_kabkota = h.id_kabkota OR h.id_kabkota IS NULL)) > 0 
                    THEN ROUND(CAST((h.capi_submit + h.capi_approved) AS REAL) / (SELECT SUM(tk.target_sampel) FROM t_target_kegiatan tk WHERE tk.id_kegiatan = h.id_kegiatan AND (tk.id_kabkota = h.id_kabkota OR h.id_kabkota IS NULL)) * 100, 2)
                    ELSE 0
                END AS progress_percentage
            FROM t_progress_history h
            LEFT JOIN m_kabkota k ON h.id_kabkota = k.id_kabkota
            WHERE h.id_kegiatan = ?
            ORDER BY h.tanggal_update ASC
        ', [$id_kegiatan]);

        foreach ($history as &$h) {
            if ($h->progress_percentage > 100) $h->progress_percentage = 100;
        }

        return response()->json($history);
    }
}
