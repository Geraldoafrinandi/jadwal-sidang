<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BimbinganPkl extends Model
{
    use HasFactory;

    // Tentukan nama tabel
    protected $table = 'bimbingan_pkl';

    // Tentukan primary key jika tidak menggunakan 'id'
    protected $primaryKey = 'id_bimbingan_pkl';

    // Tentukan kolom yang boleh diisi mass-assignable
    protected $fillable = [
        'pkl_id',
        'kegiatan',
        'tgl_kegiatan_awal',
        'tgl_kegiatan_akhir',
        'file_dokumentasi',
        'komentar',
        'status',
    ];

    public $timestamps = false;

    // Relasi dengan model MhsPkl (relasi banyak ke satu)
    public function mhsPkl()
    {
        return $this->belongsTo(MhsPkl::class, 'pkl_id', 'id_mhs_pkl'); // Relasi dengan pkl_id di bimbingan_pkl
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id'); // Relasi dengan mahasiswa_id di bimbingan_pkl
    }
    public function dosen()
    {
        return $this->belongsTo(MhsPkl::class, 'dosen_pembimbing', 'id_dosen'); // Relasi dengan dosen_id di bimbingan_pkl
    }
    public function nilaiBimbingan()
    {
        return $this->hasOne(NilaiPembimbing::class, 'mhs_pkl_id', 'id_bimbingan_pkl');
    }
//     public function usulanPkl()
// {
//     return $this->belongsTo(UsulanPkl::class, 'pkl_id', 'id_mhs_pkl');
// }

}
