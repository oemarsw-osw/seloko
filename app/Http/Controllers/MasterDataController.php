<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class MasterDataController extends Controller {
    public function getKegiatan() {
        $rows = DB::table('m_kegiatan as k')
            ->join('m_sub_tim as st', 'k.id_sub_tim', '=', 'st.id_sub_tim')
            ->join('m_tim as t', 'st.id_tim', '=', 't.id_tim')
            ->select('k.id_kegiatan', 'k.nama_kegiatan', 'k.id_sub_tim', 'st.id_tim', 'k.metode_default', 'k.tanggal_deadline', 'st.nama_sub_tim', 't.nama_tim')
            ->orderBy('k.id_kegiatan', 'desc')
            ->get();
        return response()->json($rows);
    }

    public function getTim() {
        $rows = DB::table('m_tim')->orderBy('id_tim', 'asc')->get();
        return response()->json($rows);
    }

    public function getSubTim() {
        $rows = DB::table('m_sub_tim')->orderBy('id_tim', 'asc')->orderBy('id_sub_tim', 'asc')->get();
        return response()->json($rows);
    }
}
