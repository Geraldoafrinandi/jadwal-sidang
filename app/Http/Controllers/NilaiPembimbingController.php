<?php

namespace App\Http\Controllers;

use App\Models\BimbinganPkl;
use App\Models\MhsPkl;
use App\Models\NilaiPembimbing;
use Illuminate\Http\Request;

class NilaiPembimbingController extends Controller
{
    public function updateNilai(Request $request, $id)
    {
        $bimbingan = MhsPkl::findOrFail($id);

        // Validasi dan simpan nilai
        $validated = $request->validate([
            'keaktifan' => 'required|numeric|min:0|max:100',
            'komunikatif' => 'required|numeric|min:0|max:100',
            'problem_solving' => 'required|numeric|min:0|max:100',
        ]);

        // Hitung nilai rata-rata
        $nilaiBimbingan = round(($request->keaktifan * 0.3 + $request->komunikatif * 0.3  + $request->problem_solving * 0.4), 2);

        // Cek apakah sudah ada nilai sebelumnya
        $nilai = NilaiPembimbing::where('mhs_pkl_id', $bimbingan->pkl_id)->first();

        if ($nilai) {
            // Jika nilai sudah ada, update nilai
            $nilai->update([
                'keaktifan' => $request->keaktifan,
                'komunikatif' => $request->komunikatif,
                'problem_solving' => $request->problem_solving,
                'nilai_bimbingan' => $nilaiBimbingan, // Simpan nilai rata-rata
            ]);
        } else {
            // Jika nilai belum ada, buat data baru
            $nilai = NilaiPembimbing::create([
                'mhs_pkl_id' => $bimbingan->id_mhs_pkl,
                'keaktifan' => $request->keaktifan,
                'komunikatif' => $request->komunikatif,
                'problem_solving' => $request->problem_solving,
                'nilai_bimbingan' => $nilaiBimbingan, // Simpan nilai rata-rata
            ]);
        }

        // Menambahkan flash message untuk notifikasi
        session()->flash('success', 'Nilai berhasil disimpan!');

        return redirect()->route('bimbingan_pkl.dosen');
    }

    public function edit($id)
    {
        // Ambil data mahasiswa PKL berdasarkan ID
        $mhs = MhsPkl::with('r_nilai_pembimbing')->findOrFail($id);

        return route('bimbingan_pkl.dosen', compact('mhs'));
    }

    /**
     * Memperbarui nilai pembimbing.
     */
    public function update(Request $request, $id)
    {
        // Validasi input nilai
        $validated = $request->validate([
            'keaktifan' => 'required|numeric|min:0|max:100',
            'komunikatif' => 'required|numeric|min:0|max:100',
            'problem_solving' => 'required|numeric|min:0|max:100',
        ]);

        // Cari data mahasiswa PKL berdasarkan ID
        $mhs = MhsPkl::findOrFail($id);

        // Hitung nilai rata-rata baru
        $nilaiBimbingan = round(($validated['keaktifan'] * 0.3) +
            ($validated['komunikatif'] * 0.3) +
            ($validated['problem_solving'] * 0.4), 2);

        // Cek apakah nilai pembimbing sudah ada di database
        $nilai = NilaiPembimbing::where('mhs_pkl_id', $mhs->id_mhs_pkl)->first();

        if ($nilai) {
            // Update data nilai jika ditemukan
            $nilai->update([
                'keaktifan' => $validated['keaktifan'],
                'komunikatif' => $validated['komunikatif'],
                'problem_solving' => $validated['problem_solving'],
                'nilai_bimbingan' => $nilaiBimbingan, // Simpan nilai rata-rata baru
            ]);
        } else {
            // Jika nilai belum ada, buat data baru
            NilaiPembimbing::create([
                'mhs_pkl_id' => $mhs->id_mhs_pkl,
                'keaktifan' => $validated['keaktifan'],
                'komunikatif' => $validated['komunikatif'],
                'problem_solving' => $validated['problem_solving'],
                'nilai_bimbingan' => $nilaiBimbingan, // Simpan nilai rata-rata
            ]);
        }

        // Berikan notifikasi
        return redirect()->back()->with('success', 'Nilai berhasil diperbarui!');
    }
}
