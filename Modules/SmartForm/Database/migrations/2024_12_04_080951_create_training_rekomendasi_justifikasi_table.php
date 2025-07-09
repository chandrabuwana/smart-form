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
        Schema::create('training_rekomendasi_justifikasi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pengajuan_training_id');
            $table->date('tanggal')->nullable();
            $table->time('jam')->nullable();
            $table->string('tempat')->nullable();
            $table->integer('jenis')->default(0);
            $table->string('KodeST', 20)->nullable();
            $table->string('KodeDP', 20)->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
            $table->string('created_by', 20)->nullable();
            $table->string('updated_by', 20)->nullable();
            // $table->foreign('pengajuan_training_id')->on('pengajuan_training')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_rekomendasi_justifikasi');
    }
};
