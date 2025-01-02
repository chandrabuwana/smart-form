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
        Schema::create('pengajuan_training_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pengajuan_training_id');
            $table->bigInteger('trj_id')->nullable();
            $table->string('NIK', 20);
            $table->string('KodeDP', 20)->nullable();
            $table->string('KodeST', 20)->nullable();
            $table->string('status_id')->nullable();
            $table->integer('replacing')->nullable();
            $table->string('matrix')->nullable();
            $table->string('matrix_kompetensi')->nullable();
            $table->string('matrix_sertifikasi')->nullable();
            $table->string('matrix_masa_kerja')->nullable();
            $table->timestamps();
            $table->string('created_by', 20)->nullable();
            // $table->foreign('pengajuan_training_id')->on('pengajuan_training')->references('id');
            // $table->foreign('trj_id')->on('training_rekomendasi_justifikasi')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_training_detail');
    }
};
