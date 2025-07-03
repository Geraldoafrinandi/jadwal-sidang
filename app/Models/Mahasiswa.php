<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $primaryKey = 'id_mahasiswa';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'user_id',
        'nim',
        'prodi_id',
        'image',
        'gender',
        'status_mahasiswa',
    ];

    // Define the relationship with Prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id_prodi');
    }

    // Mahasiswa.php
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function mahasiswa()
{
    return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
}


    public function usulanPKL()
    {
        return $this->hasMany(UsulanPKL::class, 'mahasiswa_id');
    }

    public function mhsPkl()
    {
        return $this->hasOne(MhsPkl::class, 'mahasiswa_id');
    }
    public function mhsSempro()
    {
        return $this->hasOne(MhsSempro::class, 'mahasiswa_id','id_mahasiswa');
    }


}
