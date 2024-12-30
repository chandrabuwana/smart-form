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
        Schema::create('trj_pengganti', function (Blueprint $table) {
            $table->id();
            $table->text('keterangan')->nullable();
            $table->bigInteger('trj_id');
            $table->string('created_by', 20)->nullable();
            $table->string('updated_by', 20)->nullable();
            $table->timestamps();
            // $table->foreign('trj_id')->on('training_rekomendasi_justifikasi')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trj_pengganti');
    }
};
