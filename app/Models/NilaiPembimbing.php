<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiPembimbing extends Model
{
    protected $table = 'nilai_bimbingan_pkl'; // Nama tabel
    protected $primaryKey = 'id_nilai_bimbingan_pkl'; // Primary key

    protected $fillable = [
        'mhs_pkl_id',
        'keaktifan',
        'komunikatif',
        'problem_solving',
        'nilai_bimbingan',
    ];

    public $timestamps = false;

    public function mahasiswaPkl()
    {
        return $this->belongsTo(MhsPkl::class, 'mhs_pkl_id', 'id_mhs_pkl');
    }
    public function bimbinganPkl()
{
    return $this->belongsTo(BimbinganPkl::class, 'mhs_pkl_id', 'id_bimbingan_pkl'); // Sesuaikan dengan relasi yang benar
}
}
