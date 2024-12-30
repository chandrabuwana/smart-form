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
        Schema::create('training_syarat', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nilai', 50)->nullable();
            $table->string('operasi', 10)->nullable();
            $table->string('uom', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_syarat');
    }
};
