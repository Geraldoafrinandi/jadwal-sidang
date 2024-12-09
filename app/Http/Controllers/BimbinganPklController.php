<?php

namespace App\Http\Controllers;

use App\Models\MhsPkl;
use App\Models\BimbinganPkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BimbinganPklController extends Controller
{
    // Menampilkan daftar bimbingan
    public function index()
    {
        // Ambil data mahasiswa yang sedang login
        $mahasiswa = auth()->user()->mahasiswa;
        $jumlahBimbingan = BimbinganPkl::whereHas('mhsPkl.usulanPkl', function ($query) use ($mahasiswa) {
            $query->where('mahasiswa_id', $mahasiswa->id_mahasiswa);
        })->count();



        // Ambil data bimbingan PKL dengan nilai dari tabel nilai_bimbingan_pkl
        $bimbinganPKL = BimbinganPkl::with('mhsPkl.usulanPkl.mahasiswa', 'nilaiBimbingan') // Tambahkan relasi nilaiBimbingan
            ->whereHas('mhsPkl.usulanPkl', function ($query) use ($mahasiswa) {
                $query->whereHas('mahasiswa', function ($query2) use ($mahasiswa) {
                    $query2->where('id_mahasiswa', $mahasiswa->id_mahasiswa);
                });
            })
            ->get();

        return view('admin.bimbingan_pkl.index', compact('bimbinganPKL'));
    }


    public function indexDosen()
    {
        // Ambil data dosen yang sedang login
        $dosen = auth()->user()->dosen;

        // Pastikan dosen ditemukan
        if (!$dosen) {
            return redirect()->route('home')->with('error', 'Dosen tidak ditemukan.');
        }

        // Ambil data mahasiswa yang dibimbing oleh dosen yang login
        $mahasiswa = MhsPkl::with(['usulanPkl.mahasiswa', 'r_nilai_bimbingan', 'bimbinganPkl'])
            ->where('dosen_pembimbing', $dosen->id_dosen)
            ->get();


        // Return view khusus untuk dosen
        return view('admin.bimbingan_pkl.dosen', compact('mahasiswa'));
    }




    public function logbook()
    {


        // Cek apakah user adalah dosen
        $user = Auth::user();
        if ($user->role !== 'dosen') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Ambil data mahasiswa yang dibimbing oleh dosen tersebut
        $bimbingan = MhsPkl::with(['usulanPkl.mahasiswa', 'bimbinganPkl'])
            ->whereHas('usulanPkl', function ($query) use ($user) {
                $query->where('dosen_pembimbing', $user->dosen->id_dosen);
            })
            ->get();

        return view('admin.bimbingan_pkl.logbook', compact('bimbingan'));
    }











    // Menampilkan form tambah bimbingan
    public function create()
    {
        // Ambil data mahasiswa yang sedang login
        $mahasiswa = auth()->user()->mahasiswa;

        // Pastikan mahasiswa memiliki usulan PKL
        $pkl = $mahasiswa->usulanPkl()->with('mhsPkl')->first();

        // Periksa apakah usulan PKL ditemukan dan memiliki relasi mhsPkl
        if ($pkl && $pkl->mhsPkl) {
            $pkl_id = $pkl->mhsPkl->id_mhs_pkl; // Ambil id_mhs_pkl
        } else {
            $pkl_id = null; // Jika tidak ditemukan, beri nilai null atau tangani error
        }

        // Return ke view dengan data yang diperlukan
        return view('admin.bimbingan_pkl.create', compact('pkl_id'));
    }


    public function konfirmasi(Request $request, $id)
    {
        try {
            // Cari data bimbingan berdasarkan ID
            $bimbingan = BimbinganPkl::findOrFail($id);

            // Periksa status
            if ($bimbingan->status != '1') {
                // Ubah status menjadi diverifikasi
                $bimbingan->status = '1';

                // Simpan komentar jika tersedia
                if ($request->filled('komentar')) {
                    $bimbingan->komentar = $request->komentar;
                }

                // Simpan perubahan ke database
                $bimbingan->save();

                // Flash pesan sukses
                session()->flash('success', 'Bimbingan berhasil diverifikasi.');
            } else {
                // Jika sudah diverifikasi sebelumnya
                session()->flash('info', 'Bimbingan sudah diverifikasi sebelumnya.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Jika data tidak ditemukan
            session()->flash('error', 'Data bimbingan tidak ditemukan.');
            return redirect()->route('bimbingan_pkl.dosen');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan lain
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->route('bimbingan_pkl.dosen');
        }

        // Redirect ke halaman logbook setelah proses selesai
        return redirect()->route('bimbingan.logbook');
    }







    // Menyimpan data bimbingan baru
    public function store(Request $request)
    {
        // dd($request->all());
        // Validasi input form
        $mahasiswa = auth()->user()->mahasiswa;


        $request->validate([
            'pkl_id' => 'required|exists:mhs_pkl,id_mhs_pkl',
            'kegiatan' => 'required|string',
            'tgl_kegiatan_awal' => 'required|date',
            'tgl_kegiatan_akhir' => 'required|date',
            'komentar' => 'nullable|string',
            'file_dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        ]);

        $jumlahBimbingan = BimbinganPkl::whereHas('mhsPkl.usulanPkl', function ($query) use ($mahasiswa) {
            // Menggunakan relasi dari mhs_pkl ke usulan dan memeriksa mahasiswa_id
            $query->where('mahasiswa_id', $mahasiswa->id_mahasiswa);
        })->count();

        // Jika jumlah bimbingan sudah mencapai batas maksimal
        if ($jumlahBimbingan >= 16) {
            return redirect()->route('bimbingan_pkl.index')->with('warning', 'Anda hanya dapat menambahkan maksimal 16 data bimbingan.');
        }

        // Cek jika sudah ada bimbingan PKL dengan pkl_id dan kegiatan yang sama
        $existingBimbingan = BimbinganPkl::where('pkl_id', $request->input('pkl_id'))
            ->where('kegiatan', $request->input('kegiatan'))
            ->first();

        // Jika data sudah ada, berikan respons atau perbarui data tersebut
        if ($existingBimbingan) {
            return redirect()->route('bimbingan_pkl.index')->with('warning', 'Bimbingan PKL dengan kegiatan tersebut sudah ada.');
        }

        // Menyimpan data bimbingan PKL baru
        $bimbinganPkl = new BimbinganPkl();
        $bimbinganPkl->pkl_id = $request->pkl_id; // Relasi ke mhs_pkl
        $bimbinganPkl->kegiatan = $request->kegiatan;
        $bimbinganPkl->tgl_kegiatan_awal = $request->tgl_kegiatan_awal;
        $bimbinganPkl->tgl_kegiatan_akhir = $request->tgl_kegiatan_akhir; // Jika status tidak diberikan, set default ke 0 (belum diverifikasi)

        // Menangani file jika ada
        if ($request->hasFile('file_dokumentasi') && $request->file('file_dokumentasi')->isValid()) {
            $file = $request->file('file_dokumentasi');
            $fileName = $file->getClientOriginalName();  // Mengambil nama asli file
            $filePath = $file->storeAs('uploads/mahasiswa/dokumen_bimbingan_pkl', $fileName, 'public'); // Menyimpan file di storage

            $bimbinganPkl->file_dokumentasi = $filePath;  // Simpan path file ke database
        }

        // Simpan data bimbingan PKL ke database
        $bimbinganPkl->save();

        // Redirect dengan pesan sukses
        return redirect()->route('bimbingan_pkl.index')->with('success', 'Bimbingan PKL berhasil ditambahkan');
    }



    // Menampilkan form edit bimbingan
    public function edit($id)
    {
        $bimbinganPKL = BimbinganPkl::findOrFail($id);
        $mhsPKL = MhsPKL::all();
        return view('admin.bimbingan_pkl.edit', compact('bimbinganPKL', 'mhsPKL'));
    }

    // Mengupdate data bimbingan
    public function update(Request $request, $id)
    {
        $request->validate([
            'pkl_id' => 'required|exists:mhs_pkl,id_mhs_pkl',
            'kegiatan' => 'required|string',
            'tgl_kegiatan_awal' => 'required|date',
            'tgl_kegiatan_akhir' => 'required|date|after_or_equal:tgl_kegiatan_awal',
            'file_dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'komentar' => 'nullable|string',
            'status' => 'required|in:0,1', // Status di sini bisa diubah menjadi 0 atau 1
        ]);

        $bimbinganPKL = BimbinganPkl::findOrFail($id);

        // Menangani upload file jika ada
        if ($request->hasFile('file_dokumentasi')) {
            $filePath = $request->file('file_dokumentasi')->store('uploads/mahasiswa/dokumen_bimbingan_pkl', 'public');
            $bimbinganPKL->file_dokumentasi = $filePath;
        }

        // Mengupdate data bimbingan dengan status yang diberikan (dapat berubah jadi 0 atau 1)
        $bimbinganPKL->update([
            'pkl_id' => $request->pkl_id,
            'kegiatan' => $request->kegiatan,
            'tgl_kegiatan_awal' => $request->tgl_kegiatan_awal,
            'tgl_kegiatan_akhir' => $request->tgl_kegiatan_akhir,
            'komentar' => $request->komentar,
            'status' => $request->status, // Status dapat diubah
        ]);

        return redirect()->route('bimbingan_pkl.index')->with('success', 'Bimbingan PKL berhasil diperbarui.');
    }

    // Menghapus data bimbingan
    public function destroy($id)
    {
        $bimbinganPKL = BimbinganPkl::findOrFail($id);
        $bimbinganPKL->delete();

        return redirect()->route('bimbingan_pkl.index')->with('success', 'Bimbingan PKL berhasil dihapus.');
    }
}
