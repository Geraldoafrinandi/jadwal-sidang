<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsulanPkl extends Model
{
    use HasFactory;

    protected $table = 'usulan_pkl';

    protected $primaryKey = 'id_usulan_pkl';

    protected $fillable = [
        'mahasiswa_id',
        'perusahaan_id',
        'konfirmasi',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function tempatPKL()
    {
        return $this->belongsTo(TempatPKL::class, 'perusahaan_id', 'id_perusahaan'); // Adjust this line if you renamed it
    }

    public $timestamps = false;
}
