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
        Schema::create('plant_general_inspection_cmt_activity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_cmt_id')->constrained('plant_general_inspection_cmt');
            $table->string('category');
            $table->string('activity');
            $table->string('critical_point');
            $table->boolean('pre_inspect')->nullable();
            $table->boolean('final_inspect')->nullable();
            $table->boolean('delivery_inspect')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant_general_inspection_cmt_activity');
    }
};
