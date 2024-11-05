<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerPkl extends Model
{
    use HasFactory;

    protected $table = 'ver_pkl';

    protected $primaryKey = 'id_ver_pkl';

    protected $fillable = [
        'mahasiswa_id',
        'nilai_industri',
        'laporan_pkl',
        'status',
    ];
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id_mahasiswa');
    }



    public $timestamps = false;
}
