<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MhsSempro extends Model
{
    use HasFactory;

    protected $table = 'mhs_sempro';
    public $timestamps = false;

    protected $primaryKey = 'id_sempro';

    protected $fillable = [
        'mahasiswa_id',
        'judul',
        'file_sempro',
        'pembimbing_satu',
        'pembimbing_dua',
        'penguji',
        'tanggal_sempro',
        'ruangan_id',
        'sesi_id',
        'status_judul',
    ];

    public function r_mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id_mahasiswa');
    }
    public function r_pembimbing_satu()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_satu', 'id_dosen');
    }
    public function r_pembimbing_dua()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_dua', 'id_dosen');
    }
    public function r_penguji()
    {
        return $this->belongsTo(Dosen::class, 'penguji', 'id_dosen');
    }
    public function r_ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id', 'id_ruangan');
    }
    public function r_sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id_sesi');
    }
    public function r_nilaiSempro()
    {
        return $this->hasOne(NilaiSempro::class, 'sempro_id', 'id_sempro');
    }
    public function r_nilai_pembimbing_satu()
    {
        return $this->hasOne(NilaiSempro::class, 'sempro_id', 'id_sempro')
            ->where('status', '0');
    }

    public function r_nilai_pembimbing_dua()
    {
        return $this->hasOne(NilaiSempro::class, 'sempro_id', 'id_sempro')
            ->where('status', '1');
    }

    public function r_nilai_penguji()
    {
        return $this->hasOne(NilaiSempro::class, 'sempro_id', 'id_sempro')
            ->where('status', '2');
    }
    public function r_mhs_ta()
    {
        return $this->belongsTo(MhsTa::class, 'mhs_ta_id');
    }
}
