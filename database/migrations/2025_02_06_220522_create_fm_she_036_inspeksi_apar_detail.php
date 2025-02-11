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
        Schema::create('FM_SHE_036_INSPEKSI_APAR_DETAIL', function (Blueprint $table) {
            $table->integer('id_inspeksi_apar');
            $table->string('lokasi_apar');
            $table->string('jenis_apar');
            $table->string('berat_apar');
            $table->string('tekanan_tabung');
            $table->string('tabung');
            $table->string('handle');
            $table->string('label_tabung');
            $table->string('selang');
            $table->string('label_kartu');
            $table->date('berlaku_sampai');
            $table->string('metode_pemenuhan');
            $table->string('pic');
            $table->date('tanggal');
            $table->string('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FM_SHE_036_INSPEKSI_APAR_DETAIL');
    }
};
