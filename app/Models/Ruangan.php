<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangan';
    protected $primaryKey = 'id_ruangan';

    protected $fillable = [
        'ruangan',
    ];

    public function mhsPKL()
    {
        return $this->hasMany(MhsPKL::class, 'ruangan');
    }
    public function mhs_ta()
    {
        return $this->hasMany(MhsTa::class, 'ruangan_id', 'id_ruangan');
    }
}
