<?php

namespace App\Exports;

use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DosenExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Load the 'prodi', 'jurusan', dan 'user' relationships untuk mengakses detail
        return Dosen::with(['prodi', 'jurusan', 'user'])->get(['nama_dosen', 'nidn', 'gender', 'prodi_id', 'jurusan_id', 'status_dosen', 'user_id']);
    }

    // Define the headers for the Excel file
    public function headings(): array
    {
        return [
            'Nama Dosen',
            'NIDN',
            'Gender',
            'Prodi',
            'Jurusan',
            'Status Dosen',
            'Email',
            'Password',
        ];
    }

    public function map($dosen): array
    {
        return [
            $dosen->nama_dosen,
            $dosen->nidn,
            $dosen->gender == 1 ? 'Laki-laki' : 'Perempuan', // Gender
            $dosen->prodi ? $dosen->prodi->prodi : 'N/A', // Fetching prodi name
            $dosen->jurusan ? $dosen->jurusan->nama_jurusan : 'N/A', // Fetching jurusan name
            $dosen->status_dosen == 1 ? 'Aktif' : 'Tidak aktif', // Status of the dosen
            $dosen->user ? $dosen->user->email : 'N/A', // Fetching email
            $dosen->user ? $dosen->user->password : 'N/A', // Fetching hashed password
        ];
    }
}
