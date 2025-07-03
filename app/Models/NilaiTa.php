<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiTa extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_nilai_sidang_ta';
    protected $table = 'nilai_sidang_ta';

    public $timestamps = false;



    protected $fillable = [
        'ta_id',
        'presentasi_sikap_penampilan',
        'presentasi_komunikasi_sistematika',
        'presentasi_penguasaan_materi',
        'makalah_identifikasi_masalah',
        'makalah_relevansi_teori',
        'makalah_metode_algoritma',
        'makalah_hasil_pembahasan',
        'makalah_kesimpulan_saran',
        'makalah_bahasa_tata_tulis',
        'produk_kesesuaian_fungsional',
        'nilai_sidang',
        'status'
    ];


    public function mhsTa()
    {
        return $this->belongsTo(MhsTa::class, 'ta_id', 'id_ta');
    }
}
