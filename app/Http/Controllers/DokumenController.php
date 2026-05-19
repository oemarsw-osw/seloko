<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DokumenController extends Controller {
    public function saveDokumen(Request $request) {
        $request->validate([
            'id_kegiatan' => 'required',
            'id_periode' => 'required',
            'kategori_dokumen' => 'required',
            'nama_dokumen' => 'required',
            'url_gdrive' => 'required'
        ]);

        $id_kegiatan = $request->id_kegiatan;
        $id_periode = $request->id_periode;
        $kategori_dokumen = $request->kategori_dokumen;
        $nama_dokumen = $request->nama_dokumen;
        $url_gdrive = $request->url_gdrive;
        $userId = 1; // Fallback or current user

        $row = DB::table('t_dokumen_survei')
            ->where('id_kegiatan', $id_kegiatan)
            ->where('id_periode', $id_periode)
            ->where('kategori_dokumen', $kategori_dokumen)
            ->first();

        if ($row) {
            DB::table('t_dokumen_survei')
                ->where('id_dokumen', $row->id_dokumen)
                ->update([
                    'nama_dokumen' => $nama_dokumen,
                    'url_gdrive' => $url_gdrive,
                    'updated_by' => $userId,
                    'tanggal_upload' => DB::raw('CURRENT_TIMESTAMP')
                ]);
            return response()->json(['message' => 'Dokumen berhasil diperbarui']);
        } else {
            DB::table('t_dokumen_survei')->insert([
                'id_kegiatan' => $id_kegiatan,
                'id_periode' => $id_periode,
                'kategori_dokumen' => $kategori_dokumen,
                'nama_dokumen' => $nama_dokumen,
                'url_gdrive' => $url_gdrive,
                'updated_by' => $userId
            ]);
            return response()->json(['message' => 'Dokumen berhasil ditambahkan']);
        }
    }
}
