<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use App\Models\Dosen;
use App\Models\MhsTa;
use App\Models\Ruangan;
use App\Models\Pimpinan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MhsTaController extends Controller
{
    public function indexMhs()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        // dd($mahasiswa->mhsSempro->toArray());

        $data_mahasiswa_ta = MhsTa::where('sempro_id', $mahasiswa->mhsSempro->id_sempro)->get();

        // dd($data_mahasiswa_ta->toArray());

        return view('admin.sidang_ta.mahasiswa', compact('mahasiswa', 'data_mahasiswa_ta'));
    }

    public function store(Request $request)
    {
        // dd($request->toArray());
        // dd($request->sempro_id);


        $request->validate([
            'sempro_id' => 'required|exists:mhs_sempro,id_sempro',
            'proposal_final' => 'required|file|mimes:pdf|max:2048',
            'laporan_ta' => 'nullable|file|mimes:pdf|max:2048',
            'tugas_akhir' => 'nullable|file|mimes:pdf|max:2048',
            'status_berkas' => 'nullable|string',
        ]);

        try {
            $proposalFinalPath = $request->file('proposal_final')->store('ta_files', 'public');
            $laporanTaPath = $request->file('laporan_ta') ? $request->file('laporan_ta')->store('ta_files', 'public') : null;
            $tugasAkhirPath = $request->file('tugas_akhir') ? $request->file('tugas_akhir')->store('ta_files', 'public') : null;
            if ($request->hasFile('proposal_final') && $request->file('proposal_final')->isValid()) {
                $file = $request->file('proposal_final');
                $fileName = $file->getClientOriginalName();
                $proposalFinalPath = $file->storeAs('uploads/mahasiswa/proposal_final', $fileName, 'public');
            }


            if ($request->hasFile('laporan_ta') && $request->file('laporan_ta')->isValid()) {
                $file = $request->file('laporan_ta');
                $fileName = $file->getClientOriginalName();
                $laporanTaPath = $file->storeAs('uploads/mahasiswa/laporan_ta', $fileName, 'public');
            }


            if ($request->hasFile('tugas_akhir') && $request->file('tugas_akhir')->isValid()) {
                $file = $request->file('tugas_akhir');
                $fileName = $file->getClientOriginalName();
                $tugasAkhirPath = $file->storeAs('uploads/mahasiswa/tugas_akhir', $fileName, 'public');
            }


            $ta = new MhsTa();
            $ta->sempro_id = $request->sempro_id;
            $ta->proposal_final = $proposalFinalPath;
            $ta->laporan_ta = $laporanTaPath;
            $ta->tugas_akhir = $tugasAkhirPath;
            $ta->status_berkas = '0';
            $ta->save();




            return redirect()->route('ta.index.mhs')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function konfirmasi($id)
    {

        $ta = MhsTa::findOrFail($id);

        $ta->status_berkas = '1';
        $ta->save();


        return redirect()->route('ta.kaprodi', compact('ta'));
    }

    public function indexKaprodi()
    {

        $ta = MhsTa::with('r_mhs_sempro')->get();
        $dosens = Dosen::all();
        $ruangans = Ruangan::all();
        $sesies = Sesi::all();

        $usedRuanganSesi = DB::table('mhs_ta')
        ->select('ruangan_id', 'sesi_id', 'tanggal_ta')
        ->get();

    // Filter ruangan dan sesi yang tersedia
    $availableRuangans = $ruangans->filter(function ($ruangan) use ($usedRuanganSesi) {
        return !$usedRuanganSesi->contains('ruangan_id', $ruangan->id_ruangan);
    });

    $availableSesies = $sesies->filter(function ($sesi) use ($usedRuanganSesi) {
        return !$usedRuanganSesi->contains('sesi_id', $sesi->id_sesi);
    });

        return view('admin.sidang_ta.konfirmasi', compact('ta', 'dosens', 'ruangans', 'sesies'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'pembimbing_satu_id' => 'required|exists:dosen,id_dosen',
            'pembimbing_dua_id' => 'required|exists:dosen,id_dosen',
            'sekretaris' => 'required|exists:dosen,id_dosen',
            'penguji_1' => 'required|exists:dosen,id_dosen',
            'penguji_2' => 'required|exists:dosen,id_dosen',
            'tanggal_ta' => 'required|date',
            'ruangan_id' => 'required|exists:ruangan,id_ruangan',
            'sesi_id' => 'required|exists:sesi,id_sesi',
        ]);

        // Periksa apakah ruangan dan sesi sudah digunakan (kecuali data yang sedang diubah)
        $ruanganDigunakan = MhsTa::where('ruangan_id', $request->ruangan_id)
            ->where('sesi_id', $request->sesi_id)
            ->where('tanggal_ta', $request->tanggal_ta)
            ->where('id_ta', '!=', $id) // Mengecualikan data yang sedang diubah
            ->exists();

        if ($ruanganDigunakan) {
            return redirect()->back()->with('error', 'Ruangan dan sesi tersebut sudah digunakan untuk tanggal yang dipilih.');
        }

        try {
            // Update data
            $ta = MhsTa::findOrFail($id);
            $ta->ketua = $request->pembimbing_satu_id;
            $ta->pembimbing_satu_id = $request->pembimbing_satu_id;
            $ta->pembimbing_dua_id = $request->pembimbing_dua_id;
            $ta->sekretaris = $request->sekretaris;
            $ta->penguji_1 = $request->penguji_1;
            $ta->penguji_2 = $request->penguji_2;
            $ta->tanggal_ta = $request->tanggal_ta;
            $ta->ruangan_id = $request->ruangan_id;
            $ta->sesi_id = $request->sesi_id;

            $ta->save();

            return redirect()->route('ta.kaprodi')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }


    public function indexDosen()
    {
        $dosen = auth()->user()->dosen;

        $mahasiswa = MhsTa::where(function ($query) use ($dosen) {
            $query->where('ketua', $dosen->id_dosen)
                ->orWhere('sekretaris', $dosen->id_dosen)
                ->orWhere('penguji_1', $dosen->id_dosen)
                ->orWhere('penguji_2', $dosen->id_dosen);
        })
            ->with('r_mhs_sempro', 'r_nilai_ketua', 'r_nilai_sekretaris', 'r_nilai_penguji_1', 'r_nilai_penguji_2')
            ->get();

        // dd($mahasiswa->toArray());



        return view('admin.sidang_ta.dosen', compact('dosen', 'mahasiswa'));
    }

    public function destroy($id)
    {
        try {
            $ta = MhsTa::findOrFail($id);

            if ($ta->proposal_final && \Storage::disk('public')->exists($ta->proposal_final)) {
                \Storage::disk('public')->delete($ta->proposal_final);
            }

            if ($ta->laporan_ta && \Storage::disk('public')->exists($ta->laporan_ta)) {
                \Storage::disk('public')->delete($ta->laporan_ta);
            }

            if ($ta->tugas_akhir && \Storage::disk('public')->exists($ta->tugas_akhir)) {
                \Storage::disk('public')->delete($ta->tugas_akhir);
            }

            $ta->delete();

            return redirect()->route('ta.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function suratTugasTa($id)
    {
        // $getDosen = Auth::user()->dosen->id_dosen;
        $mhsTa = MhsTa::with(['r_mhs_sempro', 'r_pembimbing_satu', 'r_pembimbing_dua','r_ketua','r_sekretaris', 'r_penguji_1','r_penguji_2', 'r_ruangan', 'r_sesi'])
            ->findOrFail($id);
        $kaprodi = Pimpinan::with('dosen')
            ->where('status_pimpinan', '1')
            ->whereHas('jabatanPimpinan', function ($query) {
                $query->where('kode_jabatan_pimpinan', 'Kaprodi');
            })
            // ->whereHas('dosen', function ($query) use ($mhsTa) {
            //     $query->where('prodi_id', $mhsTa->r_mahasiswa->prodi_id);
            // })
            ->first();

        $fileName = 'Laporan_MhsTa_' . $mhsTa->id_ta . '.pdf';

        $pdf = Pdf::loadView('admin.surat_tugas_ta', compact('mhsTa', 'kaprodi'));

        return $pdf->stream($fileName);
    }
}
