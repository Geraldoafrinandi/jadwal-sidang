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
        Schema::create('ver_pkl', function (Blueprint $table) {
            $table->id('id_ver_pkl');
            $table->bigInteger('mahasiswa_id');
            $table->string('nilai_industri')->nullable();
            $table->string('laporan_pkl')->nullable();
            $table->enum('status', ['0', '1'])->default(0)->comment('0: Belum Diverifikasi, 1: Diverifikasi');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ver_pkl');
    }
};
