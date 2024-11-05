<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $primaryKey = 'id_dosen';
    public $timestamps = false;
    protected $fillable = [
        'nama_dosen',
        'user_id',
        'nidn',
        'gender',
        'jurusan_id',
        'prodi_id',
        'image',
        'status_dosen',
        'golongan',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id_jurusan');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id_prodi');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        // Menghapus user terkait saat dosen dihapus
        static::deleting(function ($dosen) {
            if ($dosen->user) {
                $dosen->user->delete(); // Hapus user yang terhubung
            }
        });
    }
}
