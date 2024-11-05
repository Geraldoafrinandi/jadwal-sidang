<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        // Mengembalikan view login
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi data input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Mencoba login
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // Mendapatkan nilai dari checkbox

        if (Auth::attempt($credentials, $remember)) {
            // Login berhasil, redirect ke halaman backend
            return redirect()->intended('backend')->with('status', 'Kamu Sudah Log in!');
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email yang anda masukan salah!',
        ]);
    }

    public function store(LoginRequest $request)
    {
        // Mencoba melakukan autentikasi pengguna
        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            // Jika login berhasil, simpan nama pengguna di sesi
            session(['user_name' => Auth::user()->name]);

            return redirect()->intended('/backend'); // Ganti 'dashboard' dengan rute yang Anda inginkan
        }

        // Jika autentikasi gagal, kembali ke halaman login dengan error
        return back()->withErrors([
            'email' => 'Email atau Password salah.',
        ]);
    }

    public function destroy()
{
    // Hapus sesi user_name saat logout
    session()->forget('user_name');
    Auth::logout();

    return redirect()->route('login')->with('status', 'Kamu sudah Logout.');
}
}
