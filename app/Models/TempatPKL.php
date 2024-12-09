<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempatPKL extends Model
{
    use HasFactory;

    protected $table = 'tempat_pkl';

    protected $primaryKey = 'id_perusahaan';

    protected $fillable = [
        'nama_perusahaan',
        'deskripsi',
        'kuota',
        'status',
    ];

    public function usulanPKL()
    {
        return $this->hasMany(UsulanPKL::class, 'perusahaan_id', 'id_perusahaan'); // Adjust if renamed
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'tempat_pkl_id', 'id');
    }

    public $timestamps = false;
}
