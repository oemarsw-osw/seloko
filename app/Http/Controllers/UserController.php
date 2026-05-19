<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function getUsers(Request $request) {
        $rows = DB::table('m_user as u')
            ->leftJoin('m_kabkota as k', 'u.id_kabkota', '=', 'k.id_kabkota')
            ->leftJoin('m_sub_tim as s', 'u.id_sub_tim', '=', 's.id_sub_tim')
            ->select('u.id_user', 'u.nip', 'u.nama_user', 'u.role', 'u.id_kabkota', 'u.id_sub_tim', 'k.nama_kabkota', 's.nama_sub_tim')
            ->orderBy('u.id_user', 'asc')
            ->get();
        return response()->json($rows);
    }

    public function createUser(Request $request) {
        $request->validate([
            'nip' => 'required|unique:m_user,nip',
            'nama_user' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        $id = DB::table('m_user')->insertGetId([
            'nip' => $request->nip,
            'nama_user' => $request->nama_user,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'id_kabkota' => $request->id_kabkota ?: null,
            'id_sub_tim' => $request->id_sub_tim ?: null,
        ]);

        return response()->json(['message' => 'User berhasil ditambahkan', 'id_user' => $id]);
    }

    public function editUser(Request $request, $id) {
        $request->validate([
            'nip' => 'required',
            'nama_user' => 'required',
            'role' => 'required'
        ]);

        $data = [
            'nip' => $request->nip,
            'nama_user' => $request->nama_user,
            'role' => $request->role,
            'id_kabkota' => $request->id_kabkota ?: null,
            'id_sub_tim' => $request->id_sub_tim ?: null,
        ];

        if ($request->password && trim($request->password) !== '') {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('m_user')->where('id_user', $id)->update($data);

        return response()->json(['message' => 'User berhasil diupdate']);
    }

    public function deleteUser(Request $request, $id) {
        DB::table('m_user')->where('id_user', $id)->delete();
        return response()->json(['message' => 'User berhasil dihapus']);
    }
}
