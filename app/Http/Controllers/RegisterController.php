<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function create()
    {
        // Mengembalikan view pendaftaran
        return view('auth.register'); // Pastikan ini mengarah ke view pendaftaran yang benar
    }

    public function store(RegisterRequest $request)
{
    // Menghapus spasi di awal dan akhir password
    $password = trim($request->password);

    // Menentukan role berdasarkan password
    $role = $password === 'admin123' ? 'admin' : 'mahasiswa';



    // Membuat pengguna baru
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($password),
        'role' => $role,
    ]);

    // Setelah pendaftaran berhasil, redirect ke halaman login
    return redirect()->route('login')->with('status', 'Registration successful! Please login.');
}

}
