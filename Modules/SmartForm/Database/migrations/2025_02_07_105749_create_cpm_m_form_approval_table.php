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
        Schema::create('cpm_m_form_approval', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_jenis_approval');
            $table->string('nik');
            $table->string('KodeST', 20)->nullable();
            $table->string('KodeDP', 20)->nullable();
            $table->integer('urutan');
            $table->string('sebagai', 50)->nullable();
            $table->timestamps();
            $table->foreign('id_jenis_approval')->on('cpm_m_form_jenis_approval')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpm_m_form_approval');
    }
};
