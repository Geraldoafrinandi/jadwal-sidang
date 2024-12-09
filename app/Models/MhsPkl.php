<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MhsPkl extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'mhs_pkl';
    public $timestamps = false;

    // Tentukan primary key jika tidak menggunakan 'id'
    protected $primaryKey = 'id_mhs_pkl';

    // Tentukan kolom yang boleh diisi secara mass-assignment
    protected $fillable = [
        'usulan_id',
        'judul',
        'pembimbing_pkl',
        'tahun_pkl',
        'dokumen_nilai_industri',
        'nilai_pembimbing_industri',
        'laporan_pkl',
        'status_admin',
        'ruang_sidang',
        'dosen_pembimbing',
        'dosen_penguji',
        'tgl_sidang',
        'jam'
    ];

    // Tentukan relasi dengan model Mahasiswa (usulan_pkl)
    // Relasi dengan model UsulanPkl

    public function usulanPkl()
    {
        return $this->belongsTo(UsulanPkl::class, 'usulan_id');
    }


    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id_mahasiswa');
    }

    // Tentukan relasi dengan model Ruang
    public function ruang()
    {
        return $this->belongsTo(Ruangan::class, 'ruang_sidang','id_ruangan');
    }

    // Tentukan relasi dengan model Dosen untuk Dosen Pembimbing
    public function dosenPembimbing()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing');
    }

    // Tentukan relasi dengan model Dosen untuk Dosen Penguji
    public function dosenPenguji()
    {
        return $this->belongsTo(Dosen::class, 'dosen_penguji', 'id_dosen');
    }
    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'jam', 'id_sesi');
    }

    public function tempatPKL()
    {
        return $this->belongsTo(TempatPKL::class, 'id_perusahaan', 'id_perusahaan');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  // Pastikan 'user_id' adalah kolom yang digunakan
    }
    public function bimbinganPkl()
    {
        return $this->hasMany(BimbinganPkl::class, 'pkl_id', 'id_mhs_pkl'); // Relasi banyak ke satu dengan BimbinganPkl
    }

    public function r_nilai_bimbingan()
    {
        return $this->hasOne(NilaiPembimbing::class, 'mhs_pkl_id', 'id_mhs_pkl'); // Relasi banyak ke satu dengan BimbinganPkl
    }

    public function nilaiPkl()
    {
        return $this->hasMany(NilaiPkl::class, 'mhs_pkl_id');
    }
    public function pimpinan()
    {
        return $this->belongsTo(Pimpinan::class, 'dosen_id');
    }

    // public function r_pembimbing_pkl()
    // {
    //     return $this->belongsTo(BimbinganPkl::class, 'mhs_pkl_id', 'id_mhs_pkl'); // Relasi banyak ke satu dengan BimbinganPkl
    // }

}
