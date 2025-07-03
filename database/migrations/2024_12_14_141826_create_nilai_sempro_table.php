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
        Schema::create('nilai_sempro', function (Blueprint $table) {
            $table->id('id_nilai_sempro');
            $table->unsignedBigInteger('sempro_id');
            $table->double('pendahuluan')->nullable();
            $table->double('tinjauan_pustaka')->nullable();
            $table->double('metodologi')->nullable();
            $table->double('penggunaan_bahasa')->nullable();
            $table->double('presentasi')->nullable();
            $table->double('nilai_sempro')->nullable();
            $table->enum('status', ['0', '1', '2']);

            $table->foreign('sempro_id')->references('id_sempro')->on('mhs_sempro')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_sempro');
    }
};
