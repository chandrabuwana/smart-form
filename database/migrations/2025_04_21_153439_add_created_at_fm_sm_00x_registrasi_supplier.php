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
            $table->date('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('FM_SM_00X_REGISTRASI_SUPPLIER', function (Blueprint $table) {
            $table->dropColumn('created_at');
        });
    }
};
