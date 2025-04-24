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
        Schema::create('trj_document', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('trj_id');
            $table->integer('status')->default(0);
            $table->tinyInteger('jenis_dokumen');
            $table->string('tempat_pelaksanaan')->nullable();
            $table->string('tanggal_pelaksanaan')->nullable();
            $table->dateTime('tanggal_dibuat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('justifikasi_document');
    }
};
