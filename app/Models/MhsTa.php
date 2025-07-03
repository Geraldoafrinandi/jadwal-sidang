<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MhsTa extends Model
{
    use HasFactory;


    protected $table = 'mhs_ta';
    public $timestamps = false;


    protected $primaryKey = 'id_ta';


    protected $fillable = [
        'sempro_id',
        'proposal_final',
        'laporan_ta',
        'tugas_akhir',
        'status_berkas',
        'pembimbing_satu_id',
        'pembimbing_dua_id',
        'ketua',
        'sekretaris',
        'penguji_1',
        'penguji_2',
        'tanggal_ta',
        'ruangan_id',
        'sesi_id',
        'nilai_mahasiswa',

    ];

    public function r_mhs_sempro()
    {
        return $this->belongsTo(MhsSempro::class, 'sempro_id','id_sempro');
    }
    public function r_pembimbing_satu()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_satu_id','id_dosen');
    }
    public function r_pembimbing_dua()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_dua_id','id_dosen');
    }
    public function r_ketua()
    {
        return $this->belongsTo(Dosen::class, 'ketua','id_dosen');
    }
    public function r_sekretaris()
    {
        return $this->belongsTo(Dosen::class, 'sekretaris','id_dosen');
    }
    public function r_penguji_1()
    {
        return $this->belongsTo(Dosen::class, 'penguji_1','id_dosen');
    }
    public function r_penguji_2()
    {
        return $this->belongsTo(Dosen::class, 'penguji_2','id_dosen');
    }
    public function r_ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id', 'id_ruangan');
    }
    public function r_sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id_sesi');
    }

    public function r_nilaiTa()
    {
        return $this->hasMany(NilaiTa::class, 'ta_id', 'id_ta');
    }
    public function r_nilai_pembimbing_satu()
    {
        return $this->hasOne(NilaiTa::class, 'ta_id', 'id_ta')
            ->where('status', '0');
    }

    public function r_nilai_pembimbing_dua()
    {
        return $this->hasOne(NilaiTa::class, 'ta_id', 'id_ta')
            ->where('status', '1');
    }
    public function r_nilai_ketua()
    {
        return $this->hasOne(NilaiTa::class, 'ta_id', 'id_ta')
            ->where('status', '0');
    }
    public function r_nilai_sekretaris()
    {
        return $this->hasOne(NilaiTa::class, 'ta_id', 'id_ta')
            ->where('status', '1');
    }

    public function r_nilai_penguji_1()
    {
        return $this->hasOne(NilaiTa::class, 'ta_id', 'id_ta')
            ->where('status', '2');
    }
    public function r_nilai_penguji_2()
    {
        return $this->hasOne(NilaiTa::class, 'ta_id', 'id_ta')
            ->where('status', '3');
    }


    public static function boot()
    {
        parent::boot();

        static::saved(function ($mhsTa) {
            $nilaiSidang = $mhsTa->r_nilaiTa;

            // dd($nilaiSidang->toArray());

            if ($nilaiSidang) {
                $nilaiKetua = $nilaiSidang->where('status', '0')->first()->nilai_sidang ?? 0;
                $nilaiSekretaris = $nilaiSidang->where('status', '1')->first()->nilai_sidang ?? 0;
                $nilaiPenguji1 = $nilaiSidang->where('status', '2')->first()->nilai_sidang ?? 0;
                $nilaiPenguji2 = $nilaiSidang->where('status', '3')->first()->nilai_sidang ?? 0;

            if ($nilaiKetua == 0 && $nilaiSekretaris == 0 && $nilaiPenguji1 == 0 && $nilaiPenguji2 == 0) {
                $mhsTa->nilai_mahasiswa = 0;
                $mhsTa->keterangan = '0';
            } else {

                $nilaiRataRata = ($nilaiKetua + $nilaiSekretaris + $nilaiPenguji1 + $nilaiPenguji2) / 4;
                $mhsTa->nilai_mahasiswa = $nilaiRataRata;


                if ($nilaiRataRata >= 74) {
                    $mhsTa->keterangan = '1';
                } else {
                    $mhsTa->keterangan = '2';
                }
            }
                $mhsTa->save();

                dd($mhsTa->nilai_mahasiswa);
            }
        });
    }




}
