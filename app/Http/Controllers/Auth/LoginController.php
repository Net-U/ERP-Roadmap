<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // pastikan view ini ada: resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        // validasi input
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // cek apakah login pakai email atau username
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password
        ];

        // proses login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ambil role user
            $role = Auth::user()->role;

            // redirect berdasarkan role
            switch ($role) {
                case 'admin':
                    return redirect()->intended('/admin');
                case 'manager':
                    return redirect()->intended('/manager');
                default:
                    return redirect()->intended('/'); // user biasa ke dashboard umum
            }
        }

        // login gagal
        return back()->with('loginError', 'Username / Email atau Password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
