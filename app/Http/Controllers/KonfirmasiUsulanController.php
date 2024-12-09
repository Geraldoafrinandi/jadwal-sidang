<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Dosen;
use App\Models\MhsPkl;
use App\Models\UsulanPkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KonfirmasiUsulanController extends Controller
{
    // Menampilkan semua usulan PKL
    public function index()
    {
        // Memuat relasi yang benar
        $usulanPKL = UsulanPkl::with('mahasiswa', 'tempatPKL', 'mhsPkl.dosenPembimbing')->get();
        $dosens = Dosen::all();

        // Debugging untuk memeriksa data
        // dd($usulanPKL);

        return view('admin.konfirmasi_pkl.index', compact('usulanPKL', 'dosens'));
    }




    // Menetapkan dosen pembimbing pada usulan PKL
    public function pilihDosen(Request $request, $id)
    {
        // Validasi input
        // dd($request->all(), $id);
        $validator = Validator::make($request->all(), [
            'dosen_pembimbing' => 'nullable|exists:dosen,id_dosen',
            'tahun_pkl' => 'required|date_format:Y',
        ]);

        // Jika validasi gagal, kembali dengan error
        if ($validator->fails()) {
            session()->flash('error', 'Terdapat kesalahan pada input data.');
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Temukan usulan PKL berdasarkan ID
        $usulanPkl = UsulanPkl::find($id);

        if (!$usulanPkl) {
            // Jika usulan PKL tidak ditemukan, kirim pesan error
            return redirect()->back()->withErrors(['msg' => 'Usulan PKL tidak ditemukan.']);
        }

        // Cek apakah mahasiswa sudah ada di tabel MhsPkl berdasarkan id_usulan_pkl
        $mahasiswaPkl = MhsPkl::where('usulan_id', $usulanPkl->id_usulan_pkl)->first();

        // Mulai transaksi
        DB::beginTransaction();
        try {
            // Log untuk memastikan data yang akan disimpan
            Log::info('Data yang akan disimpan:', [
                'usulan_id' => $id, // Gunakan id_usulan_pkl yang benar
                'tahun_pkl' => $request->tahun_pkl,
                'dosen_pembimbing' => $request->dosen_pembimbing
            ]);

            if (!$mahasiswaPkl) {
                // Jika belum ada, buat data baru di MhsPkl
                $mahasiswaPkl = MhsPkl::create([
                    'usulan_id' => $id, // Masukkan id_usulan_pkl ke dalam mahasiswa_id
                    'tahun_pkl' => $request->tahun_pkl,
                    'dosen_pembimbing' => $request->dosen_pembimbing,
                ]);
            } else {
                // Jika sudah ada, update data yang diperlukan
                $mahasiswaPkl->tahun_pkl = $request->tahun_pkl;
                $mahasiswaPkl->dosen_pembimbing = $request->dosen_pembimbing ?? $mahasiswaPkl->dosen_pembimbing;
                $mahasiswaPkl->save();
            }

            // Commit transaksi jika data berhasil disimpan
            DB::commit();
            session()->flash('success', 'Data berhasil disimpan.');
            return redirect()->back();
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack(); // Rollback transaction
            \Log::error('Error saving MhsPkl: ' . $e->getMessage());

            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }
}
