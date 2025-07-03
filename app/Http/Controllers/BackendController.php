<?php

namespace App\Http\Controllers;

use DB;
use App\Models\MhsTa;
use App\Models\Mahasiswa;
use App\Models\MhsSempro;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen; // Pastikan model Dosen di-import

class BackendController extends Controller
{
    public function dashboardAdmin()
    {
        // Ambil data jadwal sidang seminar proposal
        $jadwalSempro = MhsSempro::with(['r_mahasiswa', 'r_sesi'])
            ->get()
            ->map(function ($sempro) {
                // Ubah format waktu dari "10.00-12.00" ke "YYYY-MM-DDTHH:MM:SS"
                $start = $this->parseTimeToDateTime($sempro->r_sesi->jam, 'start');
                $end = $this->parseTimeToDateTime($sempro->r_sesi->jam, 'end');

                return [
                    'title' => 'Sempro: ' . ($sempro->r_mahasiswa->nama ?? 'N/A'),
                    'start' => $start,
                    'end' => $end,
                    'color' => '#007bff', // Warna biru untuk seminar proposal
                ];
            });

        // Ambil data jadwal sidang tugas akhir
        $jadwalTa = MhsTa::with(['r_mhs_sempro.r_mahasiswa', 'r_sesi'])
            ->get()
            ->map(function ($ta) {
                // Ubah format waktu dari "10.00-12.00" ke "YYYY-MM-DDTHH:MM:SS"
                $start = $this->parseTimeToDateTime($ta->r_sesi->jam, 'start');
                $end = $this->parseTimeToDateTime($ta->r_sesi->jam, 'end');

                return [
                    'title' => 'TA: ' . ($ta->r_mhs_sempro->r_mahasiswa->nama ?? 'N/A'),
                    'start' => $start,
                    'end' => $end,
                    'color' => '#28a745', // Warna hijau untuk tugas akhir
                ];
            });

        // Gabungkan data jadwal
        $events = $jadwalSempro->merge($jadwalTa);

        // Debug data
        // dd($events);

        // Kirim data ke view
        return view('admin.dashboard_admin', compact('events'));
    }

    /**
     * Ubah format waktu dari "10.00-12.00" ke "YYYY-MM-DDTHH:MM:SS".
     *
     * @param string $time
     * @param string $type (start atau end)
     * @return string
     */
    private function parseTimeToDateTime($time, $type = 'start')
    {
        // Pisahkan waktu menjadi start dan end
        $times = explode('-', $time);

        // Ambil waktu start atau end
        $selectedTime = ($type === 'start') ? $times[0] : $times[1];

        // Ubah format "10.00" ke "10:00"
        $selectedTime = str_replace('.', ':', $selectedTime);

        // Gunakan tanggal hari ini
        $date = now()->format('Y-m-d');

        return $date . 'T' . $selectedTime . ':00';
    }

    public function dashboardMhs()
    {
        $mahasiswaId = Auth::user()->mahasiswa->id_mahasiswa;

        $sempro = MhsSempro::with(['r_mahasiswa', 'r_pembimbing_satu', 'r_pembimbing_dua', 'r_penguji', 'r_ruangan', 'r_sesi'])
            ->where('mahasiswa_id', $mahasiswaId)
            ->first();

        $ta = MhsTa::with(['r_mhs_sempro', 'r_pembimbing_satu', 'r_pembimbing_dua', 'r_ketua', 'r_sekretaris', 'r_penguji_1', 'r_penguji_2', 'r_ruangan', 'r_sesi'])
            ->where('sempro_id', $sempro->id_sempro ?? null)
            ->first();

        // Kirim data ke view
        return view('admin.dashboard_mahasiswa', compact('sempro', 'ta'));
    }

    public function dashboardDosen()
    {
        // Ambil ID dosen yang sedang login
        $dosenId = Auth::user()->dosen->id_dosen;

        // Ambil data mahasiswa yang diuji untuk seminar proposal
        $mahasiswaSempro = MhsSempro::with(['r_mahasiswa', 'r_ruangan', 'r_sesi'])
            ->where('pembimbing_satu', $dosenId)
            ->orWhere('pembimbing_dua', $dosenId)
            ->orWhere('penguji', $dosenId)
            ->get();

        // Ambil data mahasiswa yang diuji untuk tugas akhir
        $mahasiswaTa = MhsTa::with(['r_mhs_sempro', 'r_ruangan', 'r_sesi'])
            ->where('pembimbing_satu_id', $dosenId)
            ->orWhere('pembimbing_dua_id', $dosenId)
            ->orWhere('ketua', $dosenId)
            ->orWhere('sekretaris', $dosenId)
            ->orWhere('penguji_1', $dosenId)
            ->orWhere('penguji_2', $dosenId)
            ->get();

        // Kirim data ke view
        return view('admin.dashboard_dosen', compact('mahasiswaSempro', 'mahasiswaTa'));
    }
}
