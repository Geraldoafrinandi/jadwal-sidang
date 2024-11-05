<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Mahasiswa;
use App\Models\Dosen; // Pastikan model Dosen di-import
use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function index()
    {
        // Menghitung jumlah mahasiswa per jurusan
        $jumlahMahasiswaPerProdi = Mahasiswa::select('prodi_id', DB::raw('count(*) as total'))
            ->groupBy('prodi_id')
            ->get();

        // Menghitung jumlah dosen berdasarkan status
        $jumlahDosenPerStatus = Dosen::select('status_dosen', DB::raw('count(*) as total'))
            ->groupBy('status_dosen')
            ->get();

        // Memastikan bahwa data ada sebelum mengirim ke view
        if ($jumlahMahasiswaPerProdi->isEmpty()) {
            $jumlahMahasiswaPerProdi = collect([['prodi_id' => 'Tidak ada data', 'total' => 0]]);
        }

        if ($jumlahDosenPerStatus->isEmpty()) {
            $jumlahDosenPerStatus = collect([['status_dosen' => 'Tidak ada data', 'total' => 0]]);
        }

        // Mengirimkan data ke view
        return view('admin.grafik', compact('jumlahMahasiswaPerProdi', 'jumlahDosenPerStatus'));
    }
}
