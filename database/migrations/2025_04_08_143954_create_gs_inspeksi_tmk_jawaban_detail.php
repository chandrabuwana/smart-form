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
        Schema::create('gs_inspeksi_tmk_jawaban_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inspeksi_id')->nullable();
            $table->unsignedBigInteger('pertanyaan_id')->nullable();
            $table->string('jawaban')->nullable();
            $table->string('resiko')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gs_inspeksi_tmk_jawaban_detail');
    }
};
