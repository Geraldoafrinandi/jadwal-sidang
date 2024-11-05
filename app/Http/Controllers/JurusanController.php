<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    // Menampilkan daftar jurusan
    public function index()
    {
        $jurusan = Jurusan::all(); // Mengambil semua data jurusan
        return view('admin.jurusan.index', compact('jurusan'));
    }

    // Menampilkan form untuk membuat jurusan baru
    public function create()
    {
        return view('admin.jurusan.create');
    }

    // Menyimpan jurusan baru
    public function store(Request $request)
    {
        $request->validate([
            'kode_jurusan' => 'required',
            'nama_jurusan' => 'required|unique:jurusan,nama_jurusan', // Memastikan nama jurusan unik
        ]);

        Jurusan::create($request->all()); // Membuat jurusan baru

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dibuat.'); // Redirect ke halaman index
    }

    // Menampilkan form untuk mengedit jurusan
    public function edit($id_jurusan) // Pastikan nama parameter konsisten
{
    // Mengambil jurusan berdasarkan ID
    $jurusan = Jurusan::findOrFail($id_jurusan);
    return view('admin.jurusan.edit', compact('jurusan'));
}

// Memperbarui jurusan yang ada
public function update(Request $request, $id_jurusan)
{
    // Validasi input dari pengguna
    $request->validate([
        'kode_jurusan' => 'required',
        'nama_jurusan' => 'required|unique:jurusan,nama_jurusan,' . $id_jurusan . ',id_jurusan', // Memastikan nama jurusan unik, kecuali untuk yang sedang diedit
    ]);

    // Mengambil jurusan berdasarkan ID
    $jurusan = Jurusan::findOrFail($id_jurusan);

    // Memperbarui data jurusan
    $jurusan->update($request->only(['kode_jurusan', 'nama_jurusan'])); // Memperbarui dengan lebih ringkas

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
}




    // Menghapus jurusan
    public function destroy($id_jurusan)
    {
        try {
            $jurusan = Jurusan::findOrFail($id_jurusan); // Mencari jurusan berdasarkan ID

            $jurusan->delete(); // Menghapus jurusan

            return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus.'); // Redirect dengan pesan sukses
        } catch (\Exception $e) {
            return redirect()->route('jurusan.index')->with('error', 'Gagal menghapus jurusan.'); // Redirect dengan pesan kesalahan
        }
    }
}
