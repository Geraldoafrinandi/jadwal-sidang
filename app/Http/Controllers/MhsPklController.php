<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\MhsPkl;
use App\Models\Pimpinan;
use App\Models\Ruangan;
use App\Models\Sesi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MhsPklController extends Controller
{
    /**
     * Menampilkan form untuk mengedit data PKL milik mahasiswa.
     *
     * @return \Illuminate\View\View
     */

    /**
     * Menampilkan form untuk mengedit data PKL milik mahasiswa.
     *
     * @return \Illuminate\View\View
     */
    public function daftarPkl()
    {
        // Mengambil data mahasiswa yang terdaftar di PKL
        $mahasiswaPkl = MhsPkl::all();

        // Ambil data ruangan dan dosen penguji
        $ruangan = Ruangan::all(); // Ambil semua ruangan
        $dosenPenguji = Dosen::all();
        $jam = Sesi::all(); // Ambil semua dosen penguji // Ambil semua data PKL

        foreach ($mahasiswaPkl as $pkl) {
            $pkl->dosen_pembimbing = Dosen::find($pkl->dosen_pembimbing);
        }

        return view('admin.mhs_pkl.daftar_pkl', compact('mahasiswaPkl', 'ruangan', 'dosenPenguji', 'jam'));
    }

    public function edit()
    {
        // Cek jika user adalah admin
        if (auth()->user()->role === 'admin') {
            // Ambil semua data PKL dari semua mahasiswa
            $data_pkl = MhsPkl::all();  // Mengambil semua data PKL
        } else {
            // Cek apakah user memiliki data mahasiswa
            if (!auth()->user()->mahasiswa) {
                return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan untuk pengguna ini.');
            }
            $usulanPkl = auth()->user()->mahasiswa->usulanPkl->first();

            // Ambil data PKL milik mahasiswa yang sedang login
            // $data_pkl = MhsPkl::where('mahasiswa_id', auth()->user()->mahasiswa->id_mahasiswa)->first();
            // $data_pkl = auth()->user()->mahasiswa->usulanPKL->mhsPkl->id_mhs_pkl  ?? null;

            $data_pkl = $usulanPkl->mhsPkl;

            // Jika data PKL tidak ditemukan, tampilkan pesan error
            // if (!$data_pkl) {
            //     return redirect()->back()->with('error', 'Data PKL tidak ditemukan untuk mahasiswa ini.');
            // }
        }

        // Tampilkan view untuk mengedit data PKL
        return view('admin.mhs_pkl.edit', compact('data_pkl'));
    }


    /**
     * Mengupdate data PKL berdasarkan id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Temukan data PKL berdasarkan id
        $data_pkl = MhsPkl::findOrFail($id);

        // Validasi inputan
        $request->validate([
            'judul' => 'required|string|max:255',
            'pembimbing_pkl' => 'required|string|max:255',
            'dokumen_nilai_industri' => 'nullable|file|mimes:pdf',
            'laporan_pkl' => 'nullable|file|mimes:pdf',
            'nilai_pembimbing_industri' => 'nullable|numeric|min:0|max:100',
        ]);

        // Update data PKL yang dapat diubah
        $data_pkl->judul = $request->judul;
        $data_pkl->pembimbing_pkl = $request->pembimbing_pkl; // Pembimbing PKL (Dosen)
        $data_pkl->tgl_sidang = $request->tgl_sidang;
        $data_pkl->nilai_pembimbing_industri = $request->nilai_pembimbing_industri;

        // Jika ada file dokumen nilai industri yang diupload
        if ($request->hasFile('dokumen_nilai_industri')) {
            // Hapus file lama jika ada
            if ($data_pkl->dokumen_nilai_industri) {
                Storage::delete('public/uploads/mahasiswa/dokumen_nilai_industri/' . $data_pkl->dokumen_nilai_industri);
            }

            // Mendapatkan nama asli file yang diupload
            $fileName = $request->file('dokumen_nilai_industri')->getClientOriginalName();

            // Menyimpan file baru dengan nama asli di folder yang sesuai
            $filePath = $request->file('dokumen_nilai_industri')->storeAs('uploads/mahasiswa/dokumen_nilai_industri', $fileName, 'public');

            // Menyimpan nama file ke database
            $data_pkl->dokumen_nilai_industri = basename($filePath);  // hanya menyimpan nama file, bukan path lengkap
        }

        // Jika ada file laporan PKL yang diupload
        if ($request->hasFile('laporan_pkl')) {
            // Hapus file lama jika ada
            if ($data_pkl->laporan_pkl) {
                Storage::delete('public/uploads/mahasiswa/laporan_pkl/' . $data_pkl->laporan_pkl);
            }

            // Mendapatkan nama asli file yang diupload
            $fileName = $request->file('laporan_pkl')->getClientOriginalName();

            // Menyimpan file baru dengan nama asli di folder yang sesuai
            $filePath = $request->file('laporan_pkl')->storeAs('uploads/mahasiswa/laporan_pkl', $fileName, 'public');

            // Menyimpan nama file ke database
            $data_pkl->laporan_pkl = basename($filePath);  // hanya menyimpan nama file, bukan path lengkap
        }

        // Simpan perubahan data PKL
        $data_pkl->save();

        // Redirect dengan pesan sukses
        return redirect()->route('mhs_pkl.edit', $id)->with('success', 'Data PKL berhasil diperbarui.');
    }

    public function generatePdf($id)
    {
        // $getDosen = Auth::user()->dosen->id_dosen;
        $mhsPkl = MhsPkl::with(['usulanPkl', 'mahasiswa', 'dosenPembimbing', 'dosenPenguji', 'ruang'])
            ->findOrFail($id);
        $kaprodi = Pimpinan::with('dosen')
            ->where('status_pimpinan', '1')
            ->whereHas('jabatanPimpinan', function ($query) {
                $query->where('kode_jabatan_pimpinan', 'Kaprodi');
            })
            ->first();

        $fileName = 'Laporan_MhsPkl_' . $mhsPkl->id_mhs_pkl . '.pdf';

        $pdf = Pdf::loadView('admin.surat_tugas', compact('mhsPkl', 'kaprodi'));

        return $pdf->stream($fileName);
    }
}
