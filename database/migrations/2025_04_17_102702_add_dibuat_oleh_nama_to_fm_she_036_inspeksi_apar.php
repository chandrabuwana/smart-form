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
            $table->string('dibuat_oleh_nama')->nullable()->after('dibuat_oleh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fm_she_036_inspeksi_apar', function (Blueprint $table) {
            $table->dropColumn('dibuat_oleh_nama');
        });
    }
};
