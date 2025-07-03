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
        Schema::create('mhs_ta', function (Blueprint $table) {
            $table->id('id_ta');
            $table->unsignedBigInteger('sempro_id');
            $table->string('proposal_final')->nullable();
            $table->string('laporan_ta')->nullable();
            $table->string('tugas_akhir')->nullable();
            $table->enum('status_berkas', ['0', '1'])->default('0')->comment('0: Belum, 1: Sudah')->nullable();

            $table->unsignedBigInteger('pembimbing_satu_id')->nullable();
            $table->unsignedBigInteger('pembimbing_dua_id')->nullable();
            $table->unsignedBigInteger('ketua')->nullable();
            $table->unsignedBigInteger('sekretaris')->nullable();
            $table->unsignedBigInteger('penguji_1')->nullable();
            $table->unsignedBigInteger('penguji_2')->nullable();

            $table->date('tanggal_ta')->nullable();
            $table->unsignedBigInteger('ruangan_id')->nullable();
            $table->unsignedBigInteger('sesi_id')->nullable();
            $table->string('nilai_mahasiswa')->nullable();
            $table->enum('keterangan', ['0', '1','2'])->default('0')->comment('0: Belum Sidang, 1:Tdk Lulus Sidang, 2:Lulus Sidang')->nullable();
        });

        Schema::table('mhs_ta', function (Blueprint $table) {
            $table->foreign('sempro-id')->references('id_sempro')->on('mhs_sempro')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sesi_id')->references('id_sesi')->on('sesi')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('ruangan_id')->references('id_ruangan')->on('ruangan')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pembimbing_satu_id')->references('id_dosen')->on('dosen')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pembimbing_dua_id')->references('id_dosen')->on('dosen')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('ketua')->references('id_dosen')->on('dosen')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sekretaris')->references('id_dosen')->on('dosen')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('penguji_1')->references('id_dosen')->on('dosen')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('penguji_2')->references('id_dosen')->on('dosen')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mhs_ta');
    }
};
