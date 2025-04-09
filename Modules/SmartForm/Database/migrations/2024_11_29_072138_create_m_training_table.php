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
        Schema::create('m_training', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('slug', 100)->nullable();
            $table->string('mandatory_type')->nullable();
            $table->string('estimasi_sertifikat_keluar')->nullable();
            $table->string('harga')->nullable();
            $table->string('training_kategori_code')->nullable();
            $table->string("offline_online")->nullable();
            $table->text('keterangan')->nullable();
            $table->string('kode_material')->nullable();
            $table->string('kondisi_saat_ini')->nullable();
            $table->string('materi_yg_diinginkan')->nullable();
            $table->string('metode_evaluasi')->nullable();
            $table->string('department')->nullable();
            $table->string('syarat')->nullable();
            $table->string('syarat_nilai')->nullable();
            $table->string('kpi_logic_tree')->nullable();
            $table->timestamps();
            // $table->foreign('training_kategori_code')->on('training_kategori')->references('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_training');
    }
};
