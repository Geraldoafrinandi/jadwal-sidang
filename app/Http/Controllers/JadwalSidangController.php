<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\MhsPkl;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class JadwalSidangController extends Controller
{
    public function index()
    {
        // Ambil data mahasiswa PKL
        $mahasiswaPkl = MhsPkl::all();

        // Ambil data ruangan dan dosen penguji
        $ruangan = Ruangan::all(); // Ambil semua ruangan
        $dosenPenguji = Dosen::all(); // Ambil semua dosen penguji

        // Kirim data ke view
        return view('admin.mhs_pkl.daftar_pkl', compact('mahasiswaPkl', 'ruangan', 'dosenPenguji'));
    }

    public function konfirmasi($id)
    {
        $pkl = MhsPkl::findOrFail($id);
        $pkl->status_admin = '1'; // Ubah status_admin menjadi diverifikasi
        $pkl->save();

        return redirect()->back()->with('success', 'Data berhasil dikonfirmasi.');
    }



    public function create($pklId)
    {
        // Ambil data PKL berdasarkan ID
        $pkl = MhsPkl::findOrFail($pklId);

        // Ambil data ruangan dan dosen penguji
        $ruangan = Ruangan::all(); // Ambil semua ruangan
        $dosenPenguji = Dosen::all(); // Ambil semua dosen penguji

        // Kirim data ke view
        return view('jadwal_sidang.create', compact('pkl', 'ruangan', 'dosenPenguji'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'usulan_id' => 'required|exists:usulan_pkl,id_usulan_pkl',
            'ruang_sidang' => 'required|exists:ruangan,id_ruangan',
            'dosen_penguji' => 'required|exists:dosen,id_dosen',
            'tgl_sidang' => 'required|date',
            'jam' => 'required|exists:sesi,id_sesi',
        ]);

        // Cari data mhs_pkl berdasarkan usulan_id
        $jadwalSidang = MhsPkl::where('usulan_id', $validated['usulan_id'])->first();

        if ($jadwalSidang) {
            // Update data jika ditemukan
            $updated = $jadwalSidang->update([
                'ruang_sidang' => $validated['ruang_sidang'],
                'dosen_penguji' => $validated['dosen_penguji'],
                'tgl_sidang' => $validated['tgl_sidang'],
                'jam' => $validated['jam'],
            ]);

            if ($updated) {
                return redirect()->route('daftar_pkl')
                    ->with('success', 'Jadwal sidang berhasil diperbarui!');
            } else {
                return redirect()->back()->with('error', 'Gagal memperbarui data!');
            }
        } else {
            // Jika tidak ditemukan data dengan usulan_id yang diberikan
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
    }

}
