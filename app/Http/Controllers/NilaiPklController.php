<?php

namespace App\Http\Controllers;

use App\Models\MhsPkl;
use App\Models\NilaiPkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiPklController extends Controller
{
    // Menampilkan daftar mahasiswa PKL berdasarkan dosen yang login
    public function index()
    {
        // Mendapatkan data dosen yang sedang login
        $dosen = Auth::user()->dosen;

        if (!$dosen) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        // Query mahasiswa PKL yang berhubungan dengan dosen pembimbing atau penguji
        $mhsPkl = MhsPkl::with(['dosenPembimbing', 'dosenPenguji', 'nilaiPkl'])->where(function ($query) use ($dosen) {
            $query->where('dosen_pembimbing', $dosen->id_dosen)
                ->orWhere('dosen_penguji', $dosen->id_dosen);
        })->get();

        // $nilaiPkl = NilaiPkl::where('mhs_pkl_id')->get();




        // Mengembalikan data ke view
        return view('admin.mhs_pkl.nilai_pkl', compact('mhsPkl', 'dosen'));
    }

    // Menampilkan form edit nilai PKL
    public function edit($id)
    {
        $mhsPkl = MhsPkl::findOrFail($id);
        $nilaiPkl = NilaiPkl::where('mhs_pkl_id', $id)->first();

        // dd($nilaiPkl);

        return view('admin.mhs_pkl.nilai_pkl', compact('mhsPkl', 'nilaiPkl'));
    }

    // Menyimpan atau memperbarui nilai PKL
    public function update(Request $request, $id)
{


    // Validasi input data
    $validated = $request->validate([
        'bahasa' => 'nullable|numeric|min:0|max:100',
        'analisis' => 'nullable|numeric|min:0|max:100',
        'sikap' => 'nullable|numeric|min:0|max:100',
        'komunikasi' => 'nullable|numeric|min:0|max:100',
        'penyajian' => 'nullable|numeric|min:0|max:100',
        'penguasaan' => 'nullable|numeric|min:0|max:100',
    ]);

    // Menghitung total nilai
    $totalNilai = round((((
        ($request->bahasa ?? 0) * 0.15) +
        (($request->analisis ?? 0) * 0.15) +
        (($request->sikap ?? 0) * 0.15) +
        (($request->komunikasi ?? 0) * 0.15) +
        (($request->penyajian ?? 0) * 0.15) +
        (($request->penguasaan ?? 0) * 0.25)
    )), 2);

    // Mendapatkan mahasiswa PKL
    $mhsPkl = MhsPkl::findOrFail($id);

    // Mendapatkan dosen yang sedang login
    $dosen = Auth::user()->dosen;

    if (!$dosen) {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk memperbarui nilai.');
    }

    // Tentukan status berdasarkan dosen yang login
    $status = null;
    if ($dosen->id_dosen === $mhsPkl->dosen_pembimbing) {
        $status = "0"; // Dosen pembimbing
    } elseif ($dosen->id_dosen === $mhsPkl->dosen_penguji) {
        $status = "1"; // Dosen penguji
    } else {
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk memberikan nilai.');
    }

    // Cek apakah data nilai PKL untuk status ini sudah ada
    $nilaiPkl = NilaiPkl::where('mhs_pkl_id', $id)
                        ->where('status', $status)
                        ->first();

    if ($nilaiPkl) {
        // Jika data ada, lakukan update
        $nilaiPkl->update(array_merge($validated, [
            'total_nilai' => $totalNilai,
        ]));
    } else {
        // Jika data tidak ada, buat data baru
        NilaiPkl::create([
            'mhs_pkl_id' => $mhsPkl->id_mhs_pkl,
            'bahasa' => $validated['bahasa'] ?? null,
            'analisis' => $validated['analisis'] ?? null,
            'sikap' => $validated['sikap'] ?? null,
            'komunikasi' => $validated['komunikasi'] ?? null,
            'penyajian' => $validated['penyajian'] ?? null,
            'penguasaan' => $validated['penguasaan'] ?? null,
            'status' => $status,
            'total_nilai' => $totalNilai,
        ]);
    }

    return redirect()->route('admin.mhs_pkl.index')
        ->with('success', 'Nilai berhasil diperbarui!');
}

}
