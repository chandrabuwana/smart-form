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
        Schema::create('FM_LOG_037_PEMAKAIAN_SOLAR', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_dok');
            $table->string('revisi');
            $table->date('tanggal');
            $table->string('job_site');
            $table->string('no_fuel_station');
            $table->string('shift');
            $table->string('dibuat_oleh');
            $table->string('disetujui_oleh');
            $table->string('diketahui_oleh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FM_LOG_037_PEMAKAIAN_SOLAR');
    }
};
