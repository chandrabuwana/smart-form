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
        Schema::create('plant_general_inspection_cmt', function (Blueprint $table) {
            $table->id();
            $table->string('site');
            $table->string('model_unit');
            $table->string('cn');
            $table->string('hm');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant_general_inspection_cmt');
    }
};
