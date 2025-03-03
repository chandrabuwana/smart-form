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
        Schema::create('plant_general_inspection_cmt_result', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_cmt_id')->constrained('plant_general_inspection_cmt');
            $table->string('component');
            $table->string('performance')->nullable();
            $table->string('remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant_general_inspection_cmt_result');
    }
};
