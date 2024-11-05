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
        Schema::create('usulan_pkl', function (Blueprint $table) {
            $table->id('id_usulan_pkl');
            $table->unsignedBigInteger('mahasiswa_id'); // Use unsigned for foreign keys
            $table->unsignedBigInteger('perusahaan_id'); // Use unsigned for foreign keys
            $table->enum('konfirmasi', ['0', '1'])->default('0')->comment('0: Belum, 1: Sudah'); // Fixed typo in 'konfirmasi'
            $table->timestamps(); // Optional: add timestamps for created_at and updated_at
        });

        Schema::table('usulan_pkl', function (Blueprint $table) {
            $table->foreign('mahasiswa_id')->references('id_mahasiswa')->on('mahasiswa')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('perusahaan_id')->references('id_perusahaan')->on('tempat_pkl')
                ->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usulan_pkl');
    }
};
