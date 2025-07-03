<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mhs_pkl', function (Blueprint $table) {
            $table->id('id_mhs_pkl');
            $table->unsignedBigInteger('usulan_id');
            $table->text('judul')->nullable();
            $table->string('pembimbing_pkl')->nullable();
            $table->string('tahun_pkl')->nullable();
            $table->string('dokumen_nilai_industri')->nullable();
            $table->double('nilai_pembimbing_industri')->nullable();
            $table->string('laporan_pkl')->nullable();
            $table->enum('status_admin', ['0', '1'])->default(0)->comment('0: Belum Diverifikasi, 1: Diverifikasi')->nullable();
            $table->unsignedBigInteger('ruang_sidang')->nullable();
            $table->unsignedBigInteger('dosen_pembimbing')->nullable();
            $table->unsignedBigInteger('dosen_penguji')->nullable();
            $table->date('tgl_sidang')->nullable();
            $table->string('nilai_mahasiswa')->nullable();
            $table->unsignedBigInteger('jam')->nullable();

            // Menambahkan foreign key di sini
            $table->foreign('usulan_id')->references('id_usulan_pkl')->on('usulan_pkl')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('dosen_pembimbing')->references('id_dosen')->on('dosen')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('dosen_penguji')->references('id_dosen')->on('dosen')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('ruang_sidang')->references('id_ruangan')->on('ruangan')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jam')->references('id_sesi')->on('sesi')
                ->onUpdate('cascade')->onDelete('cascade');
        });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mhs_pkl');
    }
};
