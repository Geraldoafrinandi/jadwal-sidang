<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiPkl extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model
    protected $table = 'nilai_pkl';
    protected $primaryKey = 'id_nilai_pkl';

    public $timestamps = false;

    // Kolom yang boleh diisi
    protected $fillable = [
        'mhs_pkl_id',
        'bahasa',
        'analisis',
        'sikap',
        'komunikasi',
        'penyajian',
        'penguasaan',
        'status',
        'total_nilai'
    ];

    // Definisikan hubungan dengan model MhsPkl
    public function mhsPkl()
    {
        return $this->belongsTo(MhsPkl::class, 'mhs_pkl_id', 'id_mhs_pkl');
    }

    // Definisikan hubungan dengan model Dosen (untuk Pembimbing PKL)
    public function dosenPembimbing()
    {
        return $this->belongsTo(Dosen::class, 'status', 'id_dosen');
    }
    public function dosenPenguji()
    {
        return $this->belongsTo(Dosen::class, 'status', 'id_dosen');
    }

}
