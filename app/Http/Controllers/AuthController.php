<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function login(Request $request) {
        $request->validate(['nip' => 'required', 'password' => 'required']);
        $user = User::where('nip', $request->nip)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'NIP atau password salah'], 401);
        }
        
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'role' => $user->role,
            'nama' => $user->nama_user,
            'nama_user' => $user->nama_user,
            'id_user' => $user->id_user
        ]);
    }
}
