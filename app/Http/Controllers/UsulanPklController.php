<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\MhsPkl;
use App\Models\Mahasiswa;
use App\Models\TempatPKL;
use App\Models\UsulanPkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsulanPklController extends Controller
{
    public function index()
    {
        // Ambil semua data dosen
        $dosens = Dosen::all();

        // Inisialisasi variabel untuk status pendaftaran PKL mahasiswa
        $hasRegistered = false;
        $registeredCompanyName = null;
        $konfirmasiStatus = null;
        $hasRegisteredAnywhere = false;

        // Cek apakah pengguna yang sedang login adalah mahasiswa
        if (auth()->check() && auth()->user()->mahasiswa) {
            $mahasiswaId = auth()->user()->mahasiswa->id_mahasiswa;

            // Ambil data usulan PKL mahasiswa jika ada dan periksa konfirmasi statusnya
            $usulan = UsulanPkl::where('mahasiswa_id', $mahasiswaId)
                ->with('tempatPKL') // Menambahkan relasi tempatPKL
                ->first();

            if ($usulan) {
                $hasRegistered = true;
                $registeredCompanyName = $usulan->tempatPKL->nama_perusahaan ?? null;
                $konfirmasiStatus = $usulan->konfirmasi ?? null; // Ambil status konfirmasi dari usulan
            }

            // Cek apakah mahasiswa sudah terdaftar di tempat PKL manapun
            $hasRegisteredAnywhere = UsulanPkl::where('mahasiswa_id', $mahasiswaId)->exists();
        }

        // Mengambil data tempat PKL dengan relasi yang diperlukan untuk menghindari query N+1
        $tempatPKL = TempatPKL::with('usulanPKL.mahasiswa')->get();

        // Mengambil data usulan PKL untuk admin
        $usulanPKL = UsulanPkl::with(['mahasiswa', 'tempatPKL'])->get();

        // Mengambil data MhsPkl untuk keperluan lainnya
        $mhs_pkl = MhsPkl::with(['usulanPkl.mahasiswa', 'usulanPkl.tempatPKL', 'dosenPembimbing'])->get();

        // Mengirimkan data ke view
        return view('admin.usulan_pkl.index', compact(
            'mhs_pkl',
            'usulanPKL',
            'tempatPKL',
            'hasRegistered',
            'registeredCompanyName',
            'konfirmasiStatus',
            'hasRegisteredAnywhere',
            'dosens'
        ));
    }

    public function konfirmasi($id)
    {
        // Temukan usulan PKL dan konfirmasi
        $usulan = UsulanPkl::findOrFail($id);
        $usulan->konfirmasi = '1';
        $usulan->save();

        return redirect()->back()->with('success', 'Pendaftaran PKL telah dikonfirmasi.');
    }

    public function create()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        if ($mahasiswa && $mahasiswa->status_verifikasi == 1) {
            return redirect()->route('usulan_pkl.index')->with('error', 'Anda sudah diverifikasi dan tidak bisa mengubah pilihan tempat PKL.');
        }

        $perusahaans = TempatPKL::all();
        return view('admin.usulan_pkl.create', compact('perusahaans'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id_mahasiswa',
            'perusahaan_id' => 'required|exists:tempat_pkl,id_perusahaan',
        ]);

        $mahasiswaId = $request->mahasiswa_id;

        // Cek apakah mahasiswa sudah terdaftar di perusahaan yang sama
        $hasRegistered = UsulanPkl::where('mahasiswa_id', $mahasiswaId)
            ->where('perusahaan_id', $request->perusahaan_id)
            ->exists();

        if ($hasRegistered) {
            return redirect()->back()->with('error', 'Anda sudah mendaftar di tempat PKL ini.');
        }

        // Cek apakah kuota masih tersedia
        $tempatPkl = TempatPKL::findOrFail($request->perusahaan_id);
        if ($tempatPkl->usulanPKL->count() >= $tempatPkl->kuota) {
            return redirect()->back()->with('error', 'Kuota tempat PKL sudah penuh.');
        }

        // Simpan pendaftaran PKL
        UsulanPkl::create([
            'mahasiswa_id' => $mahasiswaId,
            'perusahaan_id' => $request->perusahaan_id,
            'konfirmasi' => '0', // Menunggu konfirmasi
        ]);

        return redirect()->back()->with('success', 'Pendaftaran PKL berhasil. Tunggu konfirmasi.');
    }

    public function assignDosen(Request $request, $usulan_pkl)
{
    // Validasi input
    $request->validate([
        'dosen_pembimbing' => 'nullable|exists:dosen,id_dosen',
        'tahun_pkl' => 'nullable|date_format:Y',
    ]);

    // Mendapatkan usulan PKL berdasarkan ID
    $usulanPkl = UsulanPkl::find($usulan_pkl);

    // Periksa apakah usulan PKL ditemukan
    if (!$usulanPkl) {
        return redirect()->back()->withErrors(['msg' => 'Usulan PKL tidak ditemukan.']);
    }

    // Cari mahasiswa berdasarkan usulan PKL
    $mahasiswaId = $usulanPkl->id_usulan_pkl;  // Ambil mahasiswa_id dari usulan_pkl

    // Tentukan apakah mahasiswa sudah ada dalam tabel MhsPkl
    $mahasiswaPkl = MhsPkl::firstOrNew(['mahasiswa_id' => $mahasiswaId]);

    // Log untuk memeriksa apakah data sudah ada atau baru
    \Log::info('Mencari data mahasiswa PKL dengan mahasiswa_id: ' . $mahasiswaId, ['exists' => $mahasiswaPkl->exists]);

    // Jika data belum ada, buat data baru di mhs_pkl
    if (!$mahasiswaPkl->exists) {
        // Jika belum ada, set nilai untuk data baru
        $mahasiswaPkl->judul = $request->judul;
        $mahasiswaPkl->tahun_pkl = now()->year; // Atau ambil dari request jika ada
        $mahasiswaPkl->dosen_pembimbing = $request->dosen_pembimbing;

        // Simpan data baru ke tabel mhs_pkl
        if ($mahasiswaPkl->save()) {
            \Log::info('Data mahasiswa PKL baru berhasil disimpan untuk mahasiswa_id: ' . $mahasiswaId);
        } else {
            \Log::error('Gagal menyimpan data mahasiswa PKL baru.', ['mahasiswa_id' => $mahasiswaId]);
            return redirect()->back()->withErrors(['msg' => 'Gagal menyimpan data mahasiswa PKL baru.']);
        }
    } else {
        // Jika data sudah ada, perbarui data dosen pembimbing dan tahun PKL hanya jika dosen dipilih
        if ($request->filled('dosen_pembimbing')) {
            $mahasiswaPkl->dosen_pembimbing = $request->dosen_pembimbing;
        }

        // Update tahun PKL jika diisi
        $mahasiswaPkl->tahun_pkl = $request->tahun_pkl ?? now()->year;

        // Simpan perubahan data
        if ($mahasiswaPkl->save()) {
            \Log::info('Data mahasiswa PKL berhasil diperbarui untuk mahasiswa_id: ' . $mahasiswaId);
        } else {
            \Log::error('Gagal memperbarui data mahasiswa PKL.', ['mahasiswa_id' => $mahasiswaId]);
            return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui data mahasiswa PKL.']);
        }
    }

    // Redirect dengan pesan sukses
    return redirect()->route('usulan_pkl.index')->with('success', 'Dosen Pembimbing telah berhasil ditugaskan.');
}








    public function edit($id)
    {
        $usulanPkl = UsulanPkl::findOrFail($id);
        $mahasiswas = Mahasiswa::all();
        $perusahaans = TempatPKL::all();
        return view('admin.usulan_pkl.edit', compact('usulanPkl', 'mahasiswas', 'perusahaans'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id_mahasiswa',
            'perusahaan_id' => 'required|exists:tempat_pkl,id_perusahaan',
            'konfirmasi' => 'required|in:0,1',
        ]);

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
    try {
        // Cari data berdasarkan ID
        $usulan = UsulanPKL::findOrFail($id);
        $usulan->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('konfirmasi_pkl.index')->with('success', 'Data berhasil dihapus.');
    } catch (\Exception $e) {
        // Redirect dengan pesan error
        return redirect()->route('konfirmasi_pkl.index')->with('error', 'Terjadi kesalahan saat menghapus data.');
    }
}

}
