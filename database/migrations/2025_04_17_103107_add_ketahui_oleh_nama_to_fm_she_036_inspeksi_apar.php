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
        Schema::table('fm_she_036_inspeksi_apar', function (Blueprint $table) {
            $table->string('diketahui_oleh_nama')->nullable()->after('diketahui_oleh');
			$table->string('disetujui_oleh_nama')->nullable()->after('disetujui_oleh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fm_she_036_inspeksi_apar', function (Blueprint $table) {
            $table->dropColumn('diketahui_oleh_nama');
            $table->dropColumn('disetujui_oleh_nama');
        });
    }
};
