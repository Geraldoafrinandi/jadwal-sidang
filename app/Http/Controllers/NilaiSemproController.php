<?php

namespace App\Http\Controllers;

use App\Models\MhsSempro;
use App\Models\NilaiSempro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiSemproController extends Controller
{

    public function createNilaiSempro()
    {
        $dosen = auth()->user()->dosen;
        // dd($dosen->id_dosen);

        // Ambil mahasiswa yang diuji atau dibimbing oleh dosen
        $mahasiswa = MhsSempro::where(function ($query) use ($dosen) {
            $query->where('pembimbing_satu', $dosen->id_dosen)
                ->orWhere('pembimbing_dua', $dosen->id_dosen)
                ->orWhere('penguji', $dosen->id_dosen);
        })
            ->with('r_mahasiswa', 'r_nilai_pembimbing_satu','r_nilai_pembimbing_dua','r_nilai_penguji') // Mengambil data mahasiswa yang terhubung dengan sempro
            ->get();
            // dd($mahasiswa->toArray());


        $mahasiswa_id = $mahasiswa->pluck('id_sempro');
        // dd($mahasiswa_id->toArray());
        $nilaiMahasiswa = NilaiSempro::where('sempro_id', $mahasiswa_id)
            ->with('mhsSempro.r_mahasiswa','mhsSempro.r_pembimbing_satu','mhsSempro.r_pembimbing_dua','mhsSempro.r_penguji')
            ->get();
        // dd($nilaiMahasiswa->toArray());
        return view('admin.sempro.nilai', compact('mahasiswa', 'dosen'));
    }


    public function storeNilai(Request $request, $id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'pendahuluan' => 'required|numeric|min:0|max:100',
            'tinjauan_pustaka' => 'required|numeric|min:0|max:100',
            'metodologi' => 'required|numeric|min:0|max:100',
            'penggunaan_bahasa' => 'required|numeric|min:0|max:100',
            'presentasi' => 'required|numeric|min:0|max:100',
        ]);


        $rata_rata = round((
            ($request->pendahuluan) +
            ($request->tinjauan_pustaka) +
            ($request->metodologi) +
            ($request->penggunaan_bahasa) +
            ($request->presentasi)
        ) / 5, 2);


        $mhsSempro = MhsSempro::findOrFail($id);


        $dosen = Auth::user()->dosen;

        if (!$dosen) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk memberikan nilai.');
        }


        $status = null;
        if ($dosen->id_dosen === $mhsSempro->pembimbing_satu) {
            $status = "0"; // Dosen Pembimbing
        } elseif ($dosen->id_dosen === $mhsSempro->pembimbing_dua) {
            $status = "1"; // Dosen Penguji
        } elseif ($dosen->id_dosen === $mhsSempro->penguji) {
            $status = "2";
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk memberikan nilai.');
        }


        $nilaiSempro = NilaiSempro::where('sempro_id', $id)
            ->where('status', $status)
            ->first();

        if ($nilaiSempro) {
            // Jika data ada, lakukan update
            $nilaiSempro->update(array_merge($validated, [
                'nilai_sempro' => $rata_rata
            ]));
        } else {
            // Jika data tidak ada, buat data baru
            NilaiSempro::create([
                'sempro_id' => $mhsSempro->id_sempro,
                'pendahuluan' => $validated['pendahuluan'],
                'tinjauan_pustaka' => $validated['tinjauan_pustaka'],
                'metodologi' => $validated['metodologi'],
                'penggunaan_bahasa' => $validated['penggunaan_bahasa'],
                'presentasi' => $validated['presentasi'],
                'nilai_sempro' => $rata_rata,
                'status' => $status,
            ]);
        }

        return redirect()->route('sempro.dosen')->with('success', 'Nilai berhasil disimpan atau diperbarui.');
    }
}
