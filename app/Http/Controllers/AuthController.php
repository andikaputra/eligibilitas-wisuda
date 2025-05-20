<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
