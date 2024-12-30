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
        Schema::create('training_komitmen', function (Blueprint $table) {
            $table->id();
            $table->string('NIK', 20);
            $table->string('KodeJB', 20)->nullable();
            $table->string('KodeDP', 20)->nullable();
            $table->string('KodeST', 20)->nullable();
            $table->string('nama')->nullable();
            $table->string('status')->nullable();
            $table->integer('alasan_id')->nullable();
            $table->bigInteger('m_training_id')->nullable();
            $table->bigInteger('pengajuan_training_id')->nullable();
            $table->bigInteger('pengajuan_training_detail_id')->nullable();
            $table->bigInteger('trj_id')->nullable();
            $table->text('keterangan')->nullable();
            $table->dateTime('tanggal_dibuat')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->tinyInteger('is_deleted')->nullable()->default(0);
            // $table->foreign('m_training_id')->on('m_training')->references('id');
            // $table->foreign('pengajuan_training_id')->on('pengajuan_training')->references('id');
            // $table->foreign('trj_id')->on('training_rekomendasi_justifikasi')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_komitmen');
    }
};
