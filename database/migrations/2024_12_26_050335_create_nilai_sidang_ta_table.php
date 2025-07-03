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
        Schema::create('nilai_sidang_ta', function (Blueprint $table) {
            $table->id('id_nilai_sidang_ta');
            $table->unsignedBigInteger('ta_id');
            $table->decimal('presentasi_sikap_penampilan', 5, 2);
            $table->decimal('presentasi_komunikasi_sistematika', 5, 2);
            $table->decimal('presentasi_penguasaan_materi', 5, 2);
            $table->decimal('makalah_identifikasi_masalah', 5, 2);
            $table->decimal('makalah_relevansi_teori', 5, 2);
            $table->decimal('makalah_metode_algoritma', 5, 2);
            $table->decimal('makalah_hasil_pembahasan', 5, 2);
            $table->decimal('makalah_kesimpulan_saran', 5, 2);
            $table->decimal('makalah_bahasa_tata_tulis', 5, 2);
            $table->decimal('produk_kesesuaian_fungsional', 5, 2);
            $table->double('nilai_sidang')->nullable();
            $table->enum('status', ['0', '1', '2' ,'3'])->comment('0: Ketua, 1: Sekretaris, 3: Penguji 1, 4: Penguji 2');
        });
        Schema::table('nilai_sidang_ta', function (Blueprint $table) {
            $table->foreign('ta_id')->references('id_ta')->on('mhs_ta')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_sidang_ta');
    }
};
