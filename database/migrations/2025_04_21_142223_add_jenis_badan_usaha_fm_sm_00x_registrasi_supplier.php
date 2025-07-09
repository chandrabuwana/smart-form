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
        Schema::table('FM_SM_00X_REGISTRASI_SUPPLIER', function (Blueprint $table) {
            $table->string('jenis_badan_usaha')->nullable()->after('halaman_form');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('FM_SM_00X_REGISTRASI_SUPPLIER', function (Blueprint $table) {
            $table->dropColumn('jenis_badan_usaha');
        });
    }
};
