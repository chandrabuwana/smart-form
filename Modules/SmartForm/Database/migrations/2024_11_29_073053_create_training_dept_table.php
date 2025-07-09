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
        Schema::create('training_dept', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('m_training_id');
            $table->string('KodeDP')->nullable();
            $table->timestamps();
            // $table->foreign('m_training_id')->on('m_training')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_dept');
    }
};
