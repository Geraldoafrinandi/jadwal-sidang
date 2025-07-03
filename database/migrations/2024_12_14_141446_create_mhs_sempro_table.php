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
        Schema::create('mhs_sempro', function (Blueprint $table) {
            $table->id('id_sempro');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->text('judul')->nullable();
            $table->string('file_sempro')->nullable();
            $table->unsignedBigInteger('pembimbing_satu')->nullable();
            $table->unsignedBigInteger('pembimbing_dua')->nullable();
            $table->unsignedBigInteger('penguji')->nullable();
            $table->date('tanggal_sempro')->nullable();
            $table->unsignedBigInteger('ruangan_id')->nullable();
            $table->unsignedBigInteger('sesi_id')->nullable();
            $table->enum('status_judul', ['0', '1'])->default('0')->comment('0: Ditolak, 1: Diterima')->nullable();

            $table->foreign('mahasiswa_id')->references('id_mahasiswa')->on('mahasiswa')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pembimbing_satu')->references('id_dosen')->on('dosen')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pembimbing_dua')->references('id_dosen')->on('dosen')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('penguji')->references('id_dosen')->on('dosen')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ruangan_id')->references('id_ruangan')->on('ruangan')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sesi_id')->references('id_sesi')->on('sesi')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mhs_sempro');
    }
};
