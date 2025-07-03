<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BimbinganPkl extends Model
{
    use HasFactory;

    protected $table = 'bimbingan_pkl';

    protected $primaryKey = 'id_bimbingan_pkl';

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

    public function mhsPkl()
    {
        return $this->belongsTo(MhsPkl::class, 'pkl_id', 'id_mhs_pkl');
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
    public function dosen()
    {
        return $this->belongsTo(MhsPkl::class, 'dosen_pembimbing', 'id_dosen'); 
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
