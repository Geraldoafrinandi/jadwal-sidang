<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSempro extends Model
{
    use HasFactory;

    protected $table = 'nilai_sempro';
    protected $primaryKey = 'id_nilai_sempro';
    public $timestamps = false;



    protected $fillable = [
        'sempro_id',
        'pendahuluan',
        'tinjauan_pustaka',
        'metodologi',
        'penggunaan_bahasa',
        'presentasi',
        'nilai_sempro',
        'status'
    ];


    public function mhsSempro()
    {
        return $this->belongsTo(MhsSempro::class, 'sempro_id', 'id_sempro');
    }
}
