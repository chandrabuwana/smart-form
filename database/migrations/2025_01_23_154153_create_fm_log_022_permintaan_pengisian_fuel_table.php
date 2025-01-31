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
        Schema::create('FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no');
            $table->string('no_dok')->nullable();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('nik');
            $table->string('departemen');
            $table->date('tanggal');
            $table->string('no_lambung');
            $table->string('jenis_kendaraan');
            $table->string('jam');
            $table->string('shift');
            $table->string('hm');
            $table->string('km');
            $table->string('awal');
            $table->string('akhir');
            $table->string('total_liter');
            $table->string('diserahkan_oleh')->nullable();
            $table->string('diterima_oleh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL');
    }
};
