<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KegiatanController extends Controller {
    public function createKegiatan(Request $request) {
        $request->validate([
            'id_sub_tim' => 'required',
            'nama_kegiatan' => 'required',
            'metode_default' => 'required',
        ]);

        $id_sub_tim = $request->id_sub_tim;
        $nama_kegiatan = $request->nama_kegiatan;
        $metode_default = $request->metode_default;
        $tanggal_deadline = $request->tanggal_deadline ?: null;
        $target_per_kabkota = $request->target_per_kabkota;
        $target_spesifik = $request->target_spesifik;
        $userId = 1;

        $id_kegiatan = DB::table('m_kegiatan')->insertGetId([
            'id_sub_tim' => $id_sub_tim,
            'nama_kegiatan' => $nama_kegiatan,
            'metode_default' => $metode_default,
            'tanggal_deadline' => $tanggal_deadline
        ]);

        $kabkotas = DB::table('m_kabkota')->select('id_kabkota')->get();

        foreach ($kabkotas as $kk) {
            $target = $target_per_kabkota;
            $kk_id = trim($kk->id_kabkota);
            if ($target_spesifik && isset($target_spesifik[$kk_id])) {
                $target = $target_spesifik[$kk_id];
            }

            $target = intval($target) ?: 0;

            $id_target = DB::table('t_target_kegiatan')->insertGetId([
                'id_kegiatan' => $id_kegiatan,
                'id_periode' => 1,
                'id_kabkota' => $kk->id_kabkota,
                'metode_pendataan' => $metode_default,
                'target_sampel' => $target
            ]);

            // Explicitly initialize ALL progress columns to prevent NULL issues
            DB::table('t_monitoring_progress')->insert([
                'id_target' => $id_target,
                'capi_open' => 0,
                'capi_submit' => 0,
                'capi_rejected' => 0,
                'capi_approved' => 0,
                'papi_belum_dicacah' => $metode_default === 'PAPI' ? $target : 0,
                'papi_dicacah' => 0,
                'papi_diolah' => 0,
                'updated_by' => $userId
            ]);
        }

        // Insert initial history
        DB::table('t_progress_history')->insert([
            'id_kegiatan' => $id_kegiatan,
            'id_kabkota' => null,
            'capi_submit' => 0,
            'capi_approved' => 0
        ]);

        foreach ($kabkotas as $kk) {
            DB::table('t_progress_history')->insert([
                'id_kegiatan' => $id_kegiatan,
                'id_kabkota' => $kk->id_kabkota,
                'capi_submit' => 0,
                'capi_approved' => 0
            ]);
        }

        return response()->json(['message' => 'Kegiatan berhasil ditambahkan', 'id_kegiatan' => $id_kegiatan]);
    }

    public function editKegiatan(Request $request, $id) {
        $request->validate([
            'id_sub_tim' => 'required',
            'nama_kegiatan' => 'required',
            'metode_default' => 'required',
        ]);

        DB::table('m_kegiatan')->where('id_kegiatan', $id)->update([
            'id_sub_tim' => $request->id_sub_tim,
            'nama_kegiatan' => $request->nama_kegiatan,
            'metode_default' => $request->metode_default,
            'tanggal_deadline' => $request->tanggal_deadline ?: null
        ]);

        // Target Editing Option
        $target_per_kabkota = $request->target_per_kabkota;
        $target_spesifik = $request->target_spesifik;
        
        $kabkotas = DB::table('m_kabkota')->select('id_kabkota')->get();

        foreach ($kabkotas as $kk) {
            $target = $target_per_kabkota;
            $kk_id = trim($kk->id_kabkota);
            
            if ($target_spesifik && isset($target_spesifik[$kk_id])) {
                $target = $target_spesifik[$kk_id];
            }

            $target = intval($target) ?: 0;

            // Check if target row already exists
            $exists = DB::table('t_target_kegiatan')
                ->where('id_kegiatan', $id)
                ->where('id_kabkota', $kk->id_kabkota)
                ->first();

            if ($exists) {
                // Update target_sampel and metode_pendataan
                DB::table('t_target_kegiatan')
                    ->where('id_target', $exists->id_target)
                    ->update([
                        'metode_pendataan' => $request->metode_default,
                        'target_sampel' => $target
                    ]);

                // Adjust PAPI belum dicacah if method default is PAPI
                DB::table('t_monitoring_progress')
                    ->where('id_target', $exists->id_target)
                    ->update([
                        'papi_belum_dicacah' => $request->metode_default === 'PAPI' ? $target : 0
                    ]);
            } else {
                // Insert new target and progress if somehow missing
                $id_target = DB::table('t_target_kegiatan')->insertGetId([
                    'id_kegiatan' => $id,
                    'id_periode' => 1,
                    'id_kabkota' => $kk->id_kabkota,
                    'metode_pendataan' => $request->metode_default,
                    'target_sampel' => $target
                ]);

                DB::table('t_monitoring_progress')->insert([
                    'id_target' => $id_target,
                    'capi_open' => 0,
                    'capi_submit' => 0,
                    'capi_rejected' => 0,
                    'capi_approved' => 0,
                    'papi_belum_dicacah' => $request->metode_default === 'PAPI' ? $target : 0,
                    'papi_dicacah' => 0,
                    'papi_diolah' => 0,
                    'updated_by' => 1
                ]);
            }
        }

        return response()->json(['message' => 'Kegiatan berhasil diperbarui']);
    }

    public function deleteKegiatan($id) {
        DB::transaction(function() use ($id) {
            DB::table('t_monitoring_progress')
                ->whereIn('id_target', function($query) use ($id) {
                    $query->select('id_target')->from('t_target_kegiatan')->where('id_kegiatan', $id);
                })
                ->delete();
            DB::table('t_dokumen_survei')->where('id_kegiatan', $id)->delete();
            DB::table('t_progress_history')->where('id_kegiatan', $id)->delete();
            DB::table('t_target_kegiatan')->where('id_kegiatan', $id)->delete();
            DB::table('m_kegiatan')->where('id_kegiatan', $id)->delete();
        });

        return response()->json(['message' => 'Kegiatan berhasil dihapus']);
    }
}
