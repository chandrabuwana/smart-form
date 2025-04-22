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
        Schema::table('prod_checker_form', function (Blueprint $table) {
            $table->string('site')->nullable(); 
            $table->date('tgl_diperiksa')->nullable(); 
            $table->date('tgl_diketahui')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('prod_checker_form', function (Blueprint $table) {
        //     $table->dropColumn('site');
        //     $table->dropColumn('tgl_diperiksa');
        //     $table->dropColumn('tgl_diketahui');
        // });
        Schema::dropIfExists('prod_checker_form');
    }
};
