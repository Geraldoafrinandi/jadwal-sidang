<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    use HasFactory;

    protected $table = 'sesi';
    protected $primaryKey = 'id_sesi';

    protected $fillable = [
        'sesi',
        'jam',
    ];

    public $timestamps = false;

    public function mhs_ta()
    {
        return $this->hasMany(MhsTa::class, 'ruangan_id', 'id_ruangan');
    }
}
