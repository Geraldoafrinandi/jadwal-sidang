<?php

namespace App\Http\Controllers;

use App\Models\MhsTa;
use App\Models\NilaiTa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiTaController extends Controller
{
    public function create()
    {
        $dosen = auth()->user()->dosen;
        // dd($dosen->id_dosen);

        $mahasiswa = MhsTa::where(function ($query) use ($dosen) {
            $query->where('ketua', $dosen->id_dosen)
                ->orWhere('sekretaris', $dosen->id_dosen)
                ->orWhere('penguji_1', $dosen->id_dosen)
                ->orWhere('penguji_2', $dosen->id_dosen);
        })
            ->with('r_mhs_sempro', 'r_nilai_ketua', 'r_nilai_sekretaris', 'r_nilai_penguji_1', 'r_nilai_penguji_2')
            ->get();
        // dd($mahasiswa->toArray());


        $ta_id = $mahasiswa->pluck('id_ta');
        // dd($mahasiswa_id->toArray());
        $nilaiMahasiswa = NilaiTa::where('ta_id', $ta_id)
            ->with('mhsTa.r_mhs_sempro', 'mhsTa.r_nilai_ketua', 'mhsTa.r_nilai_sekretaris', 'mhsTa.r_nilai_penguji_1', 'mhsTa.r_nilai_penguji_2')
            ->get();
        // dd($nilaiMahasiswa->toArray());
        return view('admin.sidang_ta.nilai', compact('mahasiswa', 'dosen'));
    }

    public function storeNilai(Request $request, $id)
    {

        $validated = $request->validate([
            'ta_id' => 'required|exists:mhs_ta,id_ta',
            'presentasi_sikap_penampilan' => 'required|numeric|min:0|max:100',
            'presentasi_komunikasi_sistematika' => 'required|numeric|min:0|max:100',
            'presentasi_penguasaan_materi' => 'required|numeric|min:0|max:100',
            'makalah_identifikasi_masalah' => 'required|numeric|min:0|max:100',
            'makalah_relevansi_teori' => 'required|numeric|min:0|max:100',
            'makalah_metode_algoritma' => 'required|numeric|min:0|max:100',
            'makalah_hasil_pembahasan' => 'required|numeric|min:0|max:100',
            'makalah_kesimpulan_saran' => 'required|numeric|min:0|max:100',
            'makalah_bahasa_tata_tulis' => 'required|numeric|min:0|max:100',
            'produk_kesesuaian_fungsional' => 'required|numeric|min:0|max:100',
        ]);


        $rata_rata = round(array_sum([
            $request->presentasi_sikap_penampilan,
            $request->presentasi_komunikasi_sistematika,
            $request->presentasi_penguasaan_materi,
            $request->makalah_identifikasi_masalah,
            $request->makalah_relevansi_teori,
            $request->makalah_metode_algoritma,
            $request->makalah_hasil_pembahasan,
            $request->makalah_kesimpulan_saran,
            $request->makalah_bahasa_tata_tulis,
            $request->produk_kesesuaian_fungsional
        ]) / 10, 2);


        $mhsTa = MhsTa::findOrFail($id);


        $dosen = Auth::user()->dosen;
        if (!$dosen) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk memberikan nilai.');
        }


        $status = null;
        if ($dosen->id_dosen === $mhsTa->ketua) {
            $status = "0";
        } elseif ($dosen->id_dosen === $mhsTa->sekretaris) {
            $status = "1";
        } elseif ($dosen->id_dosen === $mhsTa->penguji_1) {
            $status = "2";
        } elseif ($dosen->id_dosen === $mhsTa->penguji_2) {
            $status = "3";
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk memberikan nilai.');
        }


        $nilaiTa = NilaiTa::where('ta_id', $id)
            ->where('status', $status)
            ->first();

       
        if ($nilaiTa) {
            $nilaiTa->update(array_merge($validated, [
                'nilai_sidang' => $rata_rata
            ]));
        } else {
            NilaiTa::create(array_merge($validated, [
                'ta_id' => $mhsTa->id_ta,
                'nilai_sidang' => $rata_rata,
                'status' => $status
            ]));
        }

        return redirect()->route('ta.dosen')->with('success', 'Nilai berhasil disimpan atau diperbarui.');
    }
}
