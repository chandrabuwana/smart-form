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
        Schema::create('alat_angkut_data', function (Blueprint $table) {
            $table->id();
            $table->string('no_lambung');
            $table->string('site');
            $table->string('model');
            $table->string('sn_unit');
            $table->string('model_engine');
            $table->string('sn_engine');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat_angkut_data');
    }
};
