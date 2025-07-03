<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // if (Auth::user()->role == 'dosen') {
            //     return redirect()->route('dashboard.dosen')->with('status', 'Kamu Sudah Log in sebagai Dosen!');
            // }
            return redirect()->intended('backend')->with('status', 'Kamu Sudah Log in!');
        }

        return back()->withErrors([
            'email' => 'Email yang anda masukan salah!',
        ]);
    }

    public function store(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            session(['user_name' => Auth::user()->name]);

            return redirect()->intended('/backend');
        }

        return back()->withErrors([
            'email' => 'Email atau Password salah.',
        ]);
    }

    public function destroy()
{
    session()->forget('user_name');
    Auth::logout();

    return redirect()->route('login')->with('status', 'Kamu sudah Logout.');
}
}
