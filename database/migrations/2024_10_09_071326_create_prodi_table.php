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
       Schema::create('prodi', function (Blueprint $table) {
            $table->id('id_prodi');
            $table->string('kode_prodi');
            $table->string('prodi');
            $table->string('jenjang');
            $table->bigInteger('jurusan_id')->unsigned();
        });

        Schema::table('prodi', function (Blueprint $table) {
            $table->foreign('jurusan_id')->references('id_jurusan')->on('jurusan')
                    ->onUpdate('cascade')->onDelete('restrict');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
