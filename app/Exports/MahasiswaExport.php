<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MahasiswaExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Retrieve all mahasiswa records with related prodi data
        return Mahasiswa::with('prodi')->get()->map(function ($mahasiswa) {
            return [
                'Nama' => $mahasiswa->nama,
                'Nim' => $mahasiswa->nim,
                'Prodi' => optional($mahasiswa->prodi)->prodi ?? 'N/A', // Get the related prodi name
                'Gender' => $mahasiswa->gender == '1' ? 'Laki-laki' : 'Perempuan',
                'Status Mahasiswa' => $mahasiswa->status_mahasiswa == '1' ? 'Aktif' : 'Tidak Aktif',
            ];
        });
    }

    /**
     * Define headings for the export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama',
            'Nim',
            'Prodi',
            'Gender',
            'Status Mahasiswa',
        ];
    }
}
