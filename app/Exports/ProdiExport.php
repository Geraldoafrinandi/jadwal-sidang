<?php

namespace App\Exports;

use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProdiExport implements FromCollection,WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Prodi::with('jurusan') // Assuming you have a relationship defined in your Prodi model
            ->get(['kode_prodi', 'prodi', 'jenjang', 'jurusan_id']);
    }

    public function headings(): array
    {
        return [
            'Kode Prodi',
            'Nama Prodi',
            'Jenjang',
            'Jurusan', // This will be the name of the jurusan
        ];
    }

    public function map($prodi): array
    {
        return [
            $prodi->kode_prodi,
            $prodi->prodi,
            $prodi->jenjang,
            $prodi->jurusan ? $prodi->jurusan->nama_jurusan : 'N/A', // Use optional chaining to avoid errors
        ];
    }
}
