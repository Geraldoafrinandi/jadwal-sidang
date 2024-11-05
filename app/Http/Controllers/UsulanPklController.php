<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\TempatPKL;
use App\Models\UsulanPkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsulanPklController extends Controller
{
    public function index()
    {
        $usulanPKL = UsulanPkl::with(['mahasiswa', 'tempatPKL'])->get();
        $tempatPKL = TempatPKL::with(['usulanPKL.mahasiswa'])->get();

        $hasRegistered = false;
        $registeredCompanyName = null;
        $isVerified = false;

        // Cek apakah pengguna sudah login dan memiliki relasi ke tabel mahasiswa
        if (auth()->check() && auth()->user()->mahasiswa) {
            $mahasiswaId = auth()->user()->mahasiswa->id_mahasiswa;

            // Cari usulan PKL yang sesuai dengan ID mahasiswa yang sedang login
            $usulan = UsulanPkl::where('mahasiswa_id', $mahasiswaId)->first();

            if ($usulan) {
                $hasRegistered = true;
                $registeredCompanyName = $usulan->tempatPKL->nama_perusahaan; // Nama perusahaan tempat PKL
                $isVerified = $usulan->konfirmasi == '1'; // Periksa status verifikasi (1: Sudah terverifikasi)
            }
        }

        return view('admin.usulan_pkl.index', compact('usulanPKL', 'tempatPKL', 'hasRegistered', 'registeredCompanyName', 'isVerified'));
    }



    public function konfirmasi($id)
{
    $usulan = UsulanPKL::find($id);
    if ($usulan) {
        $usulan->konfirmasi = '1'; // Set konfirmasi menjadi 1
        $usulan->save();
        return redirect()->back()->with('success', 'Usulan PKL berhasil terkonfirmasi.');
    }
    return redirect()->back()->with('error', 'Usulan PKL tidak ditemukan.');
}


    public function create()
    {
        // Menampilkan form untuk membuat usulan PKL
        $mahasiswas = Mahasiswa::all();
        $perusahaans = TempatPKL::all();
        return view('admin.usulan_pkl.create', compact('mahasiswas', 'perusahaans'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'tempat_pkl_id' => 'required|exists:tempat_pkl,id_perusahaan',
        ]);

        UsulanPkl::create([
            'mahasiswa_id' => auth()->user()->mahasiswa->id_mahasiswa, // Ambil id mahasiswa dari user yang login
            'perusahaan_id' => $request->tempat_pkl_id,
            'konfirmasi' => '0', // Default 'belum'
        ]);
        return redirect()->back()->with('success', 'Pendaftaran tempat PKL berhasil.');
    }

    public function edit($id)
{
    // Menampilkan form untuk mengedit usulan PKL
    $usulanPkl = UsulanPkl::findOrFail($id);
    $mahasiswas = Mahasiswa::all();
    $perusahaans = TempatPKL::all();
    return view('admin.usulan_pkl.edit', compact('usulanPkl', 'mahasiswas', 'perusahaans'));
}

public function update(Request $request, $id)
{
    // Validasi input untuk update usulan PKL
    $request->validate([
        'mahasiswa_id' => 'required|exists:mahasiswa,id_mahasiswa',
        'perusahaan_id' => 'required|exists:tempat_pkl,id_perusahaan', // Ubah sesuai dengan skema database
        'konfirmasi' => 'required|in:0,1',
    ]);

    // Mengupdate data usulan PKL
    $usulanPkl = UsulanPkl::findOrFail($id);
    $usulanPkl->update([
        'mahasiswa_id' => $request->mahasiswa_id,
        'perusahaan_id' => $request->perusahaan_id,
        'konfirmasi' => $request->konfirmasi,
    ]);

    return redirect()->route('usulan_pkl.index')->with('success', 'Usulan PKL berhasil diupdate.');
}


    public function destroy($id)
    {
        // Menghapus usulan PKL berdasarkan ID
        $usulanPkl = UsulanPkl::findOrFail($id);
        $usulanPkl->delete();

        return redirect()->route('usulan_pkl.index')->with('success', 'Usulan PKL berhasil dihapus.');
    }
}
