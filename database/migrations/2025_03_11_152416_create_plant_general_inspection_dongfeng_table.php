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
        Schema::create('plant_general_inspection_dongfeng', function (Blueprint $table) {
            $table->id();
            $table->string('site');
            $table->string('model_unit');
            $table->string('cn');
            $table->string('hm');
            $table->string('date_sign1')->nullable();
            $table->string('date_sign2')->nullable();
            $table->string('date_sign3')->nullable();
            $table->string('creator');
            $table->string('dilakukan1');
            $table->string('dilakukan2');
            $table->string('diperiksa');
            $table->string('diketahui');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant_general_inspection_dongfeng');
    }
};
