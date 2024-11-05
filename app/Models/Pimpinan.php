<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pimpinan extends Model
{
    use HasFactory;

    protected $table = 'pimpinan';

    protected $primaryKey = 'id_pimpinan';
    public $timestamps = false;
    protected $fillable = [
        'dosen_id',
        'jabatan_pimpinan_id',
        'periode',
        'status_pimpinan',
    ];

    // Define the relationships
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function jabatanPimpinan()
    {
        return $this->belongsTo(JabatanPimpinan::class, 'jabatan_pimpinan_id');
    }
}
