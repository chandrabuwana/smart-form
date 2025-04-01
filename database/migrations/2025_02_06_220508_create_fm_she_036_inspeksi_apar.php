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
        Schema::create('FM_SHE_036_INSPEKSI_APAR', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_dok');
            $table->string('revisi');
            $table->string('tanggal');
            $table->string('halaman');
            $table->string('lokasi_inspeksi');
            $table->string('dibuat_oleh')->nullable();
            $table->string('diperiksa_oleh')->nullable()->after('dibuat_oleh');
            $table->string('diketahui_oleh')->nullable()->after('diperiksa_oleh');
            $table->string('disetujui_oleh')->nullable()->after('diketahui_oleh');
            $table->text('status')->nullable()->after('disetujui_oleh');
            $table->string('catatan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FM_SHE_036_INSPEKSI_APAR');
    }
};
