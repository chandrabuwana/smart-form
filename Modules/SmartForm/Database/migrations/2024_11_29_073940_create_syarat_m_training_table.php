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
        Schema::create('syarat_m_training', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('m_training_id');
            $table->bigInteger('training_syarat_id');
            // $table->foreign('m_training_id')->on('m_training')->references('id');
            // $table->foreign('training_syarat_id')->on('training_syarat')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syarat_m_training');
    }
};
