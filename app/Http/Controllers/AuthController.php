<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Tampilkan form registrasi mahasiswa.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi mahasiswa.
     */
    public function register(Request $request)
    {

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'name' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'angkatan' => 'required|string|max:20',
            'wa' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'username.required' => 'NIM wajib diisi.',
            'username.unique' => 'NIM sudah memiliki akun.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'prodi.required' => 'Program studi wajib dipilih.',
            'angkatan.required' => 'Tahun angkatan wajib dipilih.',
            'wa.required' => 'Nomor WhatsApp wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = new User();

        $user->username = $request->username;
        $user->name = $request->name;
        $user->prodi = $request->prodi;
        
        // Simpan angkatan dari input atau ekstrak dari awalan NIM jika kosong
        $angkatan = $request->angkatan;
        if (empty($angkatan) && preg_match('/^20([0-9]{2})/', $request->username, $matches)) {
            $angkatan = '20' . $matches[1];
        }
        $user->angkatan = $angkatan;

        $user->wa = $request->wa;
        $user->password = Hash::make($request->password);
        $user->role = 'mahasiswa';

        $user->save();

        return redirect()
            ->route('login')
            ->with('success',  'Registrasi berhasil! Silakan login dengan memasukkan NIM Anda pada kolom Username, kemudian gunakan password yang telah Anda buat saat registrasi.');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        $role = Auth::user()->role;

        switch ($role) {
            case 'superadmin':
                return redirect()->route('users.index');
            case 'admin_perpus':
                return redirect()->route('adminperpus.wisuda.index');
            case 'mahasiswa':
                return redirect()->route('mahasiswa.wisuda.index');
            case 'bendahara':
                return redirect()->route('bendahara.wisuda.index');
            default:
                return redirect()->route('login');
        }
    }

    return back()->withErrors(['loginError' => 'Username atau password salah.']);
}

    /**
     * Logout.
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
