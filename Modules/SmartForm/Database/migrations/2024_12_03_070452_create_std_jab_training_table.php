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
        Schema::create('std_jab_training', function (Blueprint $table) {
            $table->bigInteger('m_training_id');
            $table->string('KodeJB', 20);
            $table->primary(['m_training_id', 'KodeJB']);
            // $table->foreign('m_training_id')->on('m_training')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('std_jab_training');
    }
};
