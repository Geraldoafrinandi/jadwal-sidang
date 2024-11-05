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
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
