<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsulanPkl extends Model
{
    use HasFactory;

    protected $table = 'usulan_pkl';

    protected $primaryKey = 'id_usulan_pkl';

    protected $guarded = [];

    protected $fillable = [
        'mahasiswa_id',
        'perusahaan_id',
        'konfirmasi',
    ];




    public function mhsPkl()
    {
        return $this->hasOne(MhsPkl::class, 'usulan_id'); // Sesuaikan dengan nama kolom yang benar
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id_mahasiswa');
    }

    public function tempatPKL()
    {
        return $this->belongsTo(TempatPKL::class, 'perusahaan_id', 'id_perusahaan'); // Adjust this line if you renamed it
    }
    public function dosenPembimbing()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing','id_dosen');
    }

    public function dosenPenguji()
    {
        return $this->belongsTo(Dosen::class, 'dosen_penguji', 'id_dosen');
    }

    public $timestamps = false;
}
