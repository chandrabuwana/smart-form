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
        Schema::create('m_training_approval', function (Blueprint $table) {
            $table->id();
            $table->string('NIK', 20);
            $table->string('nama', 40)->nullable();
            $table->string('approval_role', 10);
            $table->string('KodeDP', 20);
            $table->string('KodeST', 20);
            $table->foreign('approval_role')->on('m_approval_role')->references('approval_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_training_approval');
    }
};
