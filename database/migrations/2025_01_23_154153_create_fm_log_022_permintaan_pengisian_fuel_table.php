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
        Schema::create('fm_log_022_permintaan_pengisian_fuel', function (Blueprint $table) {
            $table->id();
            $table->string('no');
            $table->string('no_dok');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('nik');
            $table->string('departemen');
            $table->timestamp('tanggal');
            $table->string('no_lambung');
            $table->string('jenis_kendaraan');
            $table->string('jam');
            $table->string('shift');
            $table->string('hm');
            $table->string('awal');
            $table->string('akhir');
            $table->string('total_liter');
            $table->string('diserahkan_oleh');
            $table->string('diterima_oleh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fm_log_022_permintaan_pengisian_fuel');
    }
};
