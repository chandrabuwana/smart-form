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
        Schema::create('FM_LOG_037_PEMAKAIAN_SOLAR_DETAIL', function (Blueprint $table) {
            $table->integer('id_pemakai_solar');
            $table->string('kode_unit');
            $table->string('jam');
            $table->string('awal');
            $table->string('akhir');
            $table->integer('total_liter');
            $table->string('nama_operator');
            $table->string('km');
            $table->string('hm');
            $table->string('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FM_LOG_037_PEMAKAIAN_SOLAR_DETAIL');
    }
};
