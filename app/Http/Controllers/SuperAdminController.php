<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wisuda;

class SuperAdminController extends Controller
{


    public function dashboard()
    {
        $wisudas = Wisuda::with('user')
            ->where('validasi_bendahara', 1)
            ->where('validasi_repo', 1)
            ->where('validasi_skripsi', 1)
            ->where('validasi_jurnal', 1)
            ->where('validasi_perpus', 1)
            ->get(); 
        return view('superadmin.validasi.index', compact('wisudas'));
    }
    public function index()
    {
        $users = User::all();
        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
                // List of Prodi (Program Studi)
        $prodiList = [
            'Pendidikan Bahasa dan Sastra Indonesia',
            'Pendidikan Guru Sekolah Dasar',
            'Pendidikan Pendidikan Bahasa Inggris',
            'Sistem Informasi',
            'Manajemen Ekonomi',
            'Pariwisata Budaya dan Keagamaan',
            'Hukum Adat',
        ];

        // List of Roles
        $roles = [
            'mahasiswa' => 'Mahasiswa',
            'admin_perpus' => 'Admin Perpustakaan',
            'bendahara' => 'Bendahara',
            'superadmin' => 'Superadmin',
        ];
        return view('superadmin.users.create', compact('roles', 'prodiList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'prodi' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'prodi' => $request->prodi,

            'role' => 'mahasiswa',
            'password' => bcrypt($request->username),
        ]);
        Wisuda:: Create([
            'user_id'=>$request->username,
            'validasi_bendara' => '1',
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
