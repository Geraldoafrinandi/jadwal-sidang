<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Sesi;
use App\Models\Dosen;
use App\Models\Ruangan;
use App\Models\Pimpinan;
use App\Models\Mahasiswa;
use App\Models\MhsSempro;
use App\Models\NilaiSempro;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class MhsSemproController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $data_mahasiswa_sempro = MhsSempro::where('mahasiswa_id', $mahasiswa->id_mahasiswa)
            ->with([
                'r_nilai_pembimbing_satu',
                'r_nilai_pembimbing_dua',
                'r_nilai_penguji',
            ])
            ->get();

        return view('admin.sempro.daftar_sempro', compact('mahasiswa', 'data_mahasiswa_sempro'));
    }



    public function indexDosen()
    {
        $dosen = auth()->user()->dosen;
        // dd($dosen->id_dosen);


        $mahasiswa = MhsSempro::where(function ($query) use ($dosen) {
            $query->where('pembimbing_satu', $dosen->id_dosen)
                ->orWhere('pembimbing_dua', $dosen->id_dosen)
                ->orWhere('penguji', $dosen->id_dosen);
        })
            ->with('r_mahasiswa', 'r_nilai_pembimbing_satu', 'r_nilai_pembimbing_dua', 'r_nilai_penguji')
            ->get();
        // dd($mahasiswa->toArray());


        // $mahasiswa_id = $mahasiswa->pluck('id_sempro');
        // // dd($mahasiswa_id->toArray());
        // $nilaiMahasiswa = NilaiSempro::where('sempro_id', $mahasiswa_id)
        //     ->with('mhsSempro.r_mahasiswa','mhsSempro.r_pembimbing_satu','mhsSempro.r_pembimbing_dua','mhsSempro.r_penguji')
        //     ->get();
        // dd($nilaiMahasiswa->toArray());
        return view('admin.sempro.dosen', compact('mahasiswa', 'dosen'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'judul' => 'required|string',
            'file_sempro' => 'nullable|file|mimes:pdf',
            'mahasiswa_id' => 'nullable|exists:mahasiswa,id_mahasiswa',
        ]);

        try {
            // $filePath = null;

            // // Upload file jika ada
            // if ($request->hasFile('file_sempro') && $request->file('file_sempro')->isValid()) {
            //     $file = $request->file('file_sempro');
            //     $file = $file->getClientOriginalName();
            //     $filePath = $request->file('file_sempro')->store('uploads/mahasiswa/dokumen_sempro', 'public');
            // }

            // Simpan data ke database
            $sempro = new MhsSempro();
            $sempro->judul = $request->judul;
            // $sempro->tanggal_sempro = $request->tanggal_sempro;
            // $sempro->file_sempro = $filePath;
            $sempro->mahasiswa_id = $request->mahasiswa_id;
            $sempro->save();

            return redirect()->route('sempro.index')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $sempro = MhsSempro::findOrFail($id);

            if ($sempro->file_sempro && \Storage::disk('public')->exists($sempro->file_sempro)) {
                \Storage::disk('public')->delete($sempro->file_sempro);
            }

            $sempro->delete();

            return redirect()->route('sempro.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function show()
    {

        $sempro = MhsSempro::all();

        $dosens = Dosen::all();
        $ruangans = Ruangan::all();
        $sesies = Sesi::all();


        return view('admin.sempro.konfirmasi_sempro', compact('sempro', 'dosens', 'ruangans', 'sesies'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'pembimbing_satu' => 'nullable|exists:dosen,id_dosen',
            'pembimbing_dua' => 'nullable|exists:dosen,id_dosen',
            'penguji' => 'nullable|exists:dosen,id_dosen',
            'ruangan_id' => 'required|exists:ruangan,id_ruangan',
            'sesi_id' => 'required|exists:sesi,id_sesi',
            'tanggal_sempro' => 'nullable|date',

        ]);

        try {
            $sempro = MhsSempro::findOrFail($id);
            $filePath = $sempro->file_sempro;

            if ($request->hasFile('file_sempro') && $request->file('file_sempro')->isValid()) {
                $file = $request->file('file_sempro');
                $file = $file->getClientOriginalName();
                $filePath = $request->file('file_sempro')->store('uploads/mahasiswa/dokumen_sempro', 'public');
            }

            $sempro->tanggal_sempro = $request->tanggal_sempro;
            // $sempro->file_sempro = $filePath;
            $sempro->pembimbing_satu = $request->pembimbing_satu;
            $sempro->pembimbing_dua = $request->pembimbing_dua;
            $sempro->penguji = $request->penguji;
            $sempro->ruangan_id = $request->ruangan_id;
            $sempro->sesi_id = $request->sesi_id;
            $sempro->status_judul = '1';

            $sempro->save();

            return redirect()->route('sempro.edit')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }
    public function konfirmasi($id)
    {
        $sempro = MhsSempro::findOrFail($id);
        $sempro->status_judul = '1';
        $sempro->save();

        return redirect()->route('sempro.edit', compact('sempro'));
    }
    public function uploadFile(Request $request, $id)
    {
        $request->validate([
            'file_sempro' => 'required|mimes:pdf|max:2048',
        ]);

        $sempro = MhsSempro::findOrFail($id);

        if ($request->hasFile('file_sempro')) {
            $file = $request->file('file_sempro');
            $filePath = $file->store('sempro_files', 'public');

            $sempro->file_sempro = $filePath;
            $sempro->save();
        }

        return redirect()->back()->with('success', 'File Sempro berhasil diunggah!');
    }

    public function suratTugasSempro($id)
    {
        // $getDosen = Auth::user()->dosen->id_dosen;
        $mhsSempro = MhsSempro::with(['r_mahasiswa', 'r_pembimbing_satu', 'r_pembimbing_dua', 'r_penguji', 'r_ruangan', 'r_sesi'])
            ->findOrFail($id);
        $kaprodi = Pimpinan::with('dosen')
            ->where('status_pimpinan', '1')
            ->whereHas('jabatanPimpinan', function ($query) {
                $query->where('kode_jabatan_pimpinan', 'Kaprodi');
            })
            ->whereHas('dosen', function ($query) use ($mhsSempro) {
                $query->where('prodi_id', $mhsSempro->r_mahasiswa->prodi_id);
            })
            ->first();

        $fileName = 'Laporan_MhsSempro_' . $mhsSempro->id_sempro . '.pdf';

        $pdf = Pdf::loadView('admin.surat_tugas_sempro', compact('mhsSempro', 'kaprodi'));

        return $pdf->stream($fileName);
    }
}
