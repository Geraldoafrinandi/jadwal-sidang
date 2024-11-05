<?php

namespace App\Exports;

use App\Models\Pimpinan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PimpinanExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Load the necessary relationships (if any) and return all data
        return Pimpinan::with(['dosen', 'jabatanPimpinan'])->get(); // Adjust relationships as needed
    }

    // Define the headers for the Excel file
    public function headings(): array
    {
        return [
            'Nama Dosen',
            'Jabatan Pimpinan',
            'Periode',
            'Status Pimpinan',
        ];
    }

    public function map($pimpinan): array
    {
        return [
            $pimpinan->dosen ? $pimpinan->dosen->nama_dosen : 'N/A', // Fetching the name of the dosen
            $pimpinan->jabatanPimpinan ? $pimpinan->jabatanPimpinan->jabatan_pimpinan : 'N/A', // Fetching the jabatan name
            $pimpinan->periode,
            $pimpinan->status_pimpinan == 1 ? 'Aktif' : 'Tidak Aktif', // Converting status for clarity
        ];
    }
}
