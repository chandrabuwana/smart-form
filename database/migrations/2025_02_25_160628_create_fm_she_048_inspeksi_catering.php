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
        Schema::create('FM_SHE_048_INSPEKSI_CATERING', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_dok_form');
            $table->string('revisi_form');
            $table->string('tanggal_form');
            $table->string('halaman_form');
            
			$table->string('nama_site');
			$table->string('department');
			$table->string('shift');
			$table->string('lokasi_kerja');
			$table->string('jumlah_inspektor');
			
			$table->smallInteger('q_penerimaan_1');
			$table->smallInteger('q_penerimaan_2');
			$table->smallInteger('q_penerimaan_3');
			$table->smallInteger('q_penerimaan_4');
			$table->smallInteger('q_penerimaan_5');
			$table->smallInteger('q_penerimaan_6');
			$table->smallInteger('q_penerimaan_7');
			$table->smallInteger('q_penerimaan_8');
			$table->smallInteger('q_penerimaan_9');
			$table->smallInteger('q_penerimaan_10');
					
			$table->smallInteger('q_penyimpanan_1');
			$table->smallInteger('q_penyimpanan_2');
			$table->smallInteger('q_penyimpanan_3');
			$table->smallInteger('q_penyimpanan_4');
			$table->smallInteger('q_penyimpanan_5');
			$table->smallInteger('q_penyimpanan_6');
			$table->smallInteger('q_penyimpanan_7');
			$table->smallInteger('q_penyimpanan_8');
			$table->smallInteger('q_penyimpanan_9');
			
			$table->smallInteger('q_persiapan_1');
			$table->smallInteger('q_persiapan_2');
			$table->smallInteger('q_persiapan_3');
			$table->smallInteger('q_persiapan_4');
			$table->smallInteger('q_persiapan_5');
			$table->smallInteger('q_persiapan_6');
			$table->smallInteger('q_persiapan_7');
			$table->smallInteger('q_persiapan_8');
			$table->smallInteger('q_persiapan_9');
			$table->smallInteger('q_persiapan_10');
					
			$table->smallInteger('q_pengolahan_1');
			$table->smallInteger('q_pengolahan_2');
			$table->smallInteger('q_pengolahan_3');
			$table->smallInteger('q_pengolahan_4');
			$table->smallInteger('q_pengolahan_5');
			$table->smallInteger('q_pengolahan_6');
			$table->smallInteger('q_pengolahan_7');
			$table->smallInteger('q_pengolahan_8');
			$table->smallInteger('q_pengolahan_9');
			$table->smallInteger('q_pengolahan_10');
			
			$table->smallInteger('q_penggolongan_sampah_1');
			$table->smallInteger('q_penggolongan_sampah_2');
			$table->smallInteger('q_penggolongan_sampah_3');
			$table->smallInteger('q_penggolongan_sampah_4');
			$table->smallInteger('q_penggolongan_sampah_5');
			$table->smallInteger('q_penggolongan_sampah_6');
			$table->smallInteger('q_penggolongan_sampah_7');
			$table->smallInteger('q_penggolongan_sampah_8');
			$table->smallInteger('q_penggolongan_sampah_9');			
			
			/** Keterangan */
			$table->string('q_keterangan_penerimaan_1')->nullable();
			$table->string('q_keterangan_penerimaan_2')->nullable();
			$table->string('q_keterangan_penerimaan_3')->nullable();
			$table->string('q_keterangan_penerimaan_4')->nullable();
			$table->string('q_keterangan_penerimaan_5')->nullable();
			$table->string('q_keterangan_penerimaan_6')->nullable();
			$table->string('q_keterangan_penerimaan_7')->nullable();
			$table->string('q_keterangan_penerimaan_8')->nullable();
			$table->string('q_keterangan_penerimaan_9')->nullable();
			$table->string('q_keterangan_penerimaan_10')->nullable();
					
			$table->string('q_keterangan_penyimpanan_1')->nullable();
			$table->string('q_keterangan_penyimpanan_2')->nullable();
			$table->string('q_keterangan_penyimpanan_3')->nullable();
			$table->string('q_keterangan_penyimpanan_4')->nullable();
			$table->string('q_keterangan_penyimpanan_5')->nullable();
			$table->string('q_keterangan_penyimpanan_6')->nullable();
			$table->string('q_keterangan_penyimpanan_7')->nullable();
			$table->string('q_keterangan_penyimpanan_8')->nullable();
			$table->string('q_keterangan_penyimpanan_9')->nullable();
			
			$table->string('q_keterangan_persiapan_1')->nullable();
			$table->string('q_keterangan_persiapan_2')->nullable();
			$table->string('q_keterangan_persiapan_3')->nullable();
			$table->string('q_keterangan_persiapan_4')->nullable();
			$table->string('q_keterangan_persiapan_5')->nullable();
			$table->string('q_keterangan_persiapan_6')->nullable();
			$table->string('q_keterangan_persiapan_7')->nullable();
			$table->string('q_keterangan_persiapan_8')->nullable();
			$table->string('q_keterangan_persiapan_9')->nullable();
			$table->string('q_keterangan_persiapan_10')->nullable();
					
			$table->string('q_keterangan_pengolahan_1')->nullable();
			$table->string('q_keterangan_pengolahan_2')->nullable();
			$table->string('q_keterangan_pengolahan_3')->nullable();
			$table->string('q_keterangan_pengolahan_4')->nullable();
			$table->string('q_keterangan_pengolahan_5')->nullable();
			$table->string('q_keterangan_pengolahan_6')->nullable();
			$table->string('q_keterangan_pengolahan_7')->nullable();
			$table->string('q_keterangan_pengolahan_8')->nullable();
			$table->string('q_keterangan_pengolahan_9')->nullable();
			$table->string('q_keterangan_pengolahan_10')->nullable();
			
			$table->string('q_keterangan_penggolongan_sampah_1')->nullable();
			$table->string('q_keterangan_penggolongan_sampah_2')->nullable();
			$table->string('q_keterangan_penggolongan_sampah_3')->nullable();
			$table->string('q_keterangan_penggolongan_sampah_4')->nullable();
			$table->string('q_keterangan_penggolongan_sampah_5')->nullable();
			$table->string('q_keterangan_penggolongan_sampah_6')->nullable();
			$table->string('q_keterangan_penggolongan_sampah_7')->nullable();
			$table->string('q_keterangan_penggolongan_sampah_8')->nullable();
			$table->string('q_keterangan_penggolongan_sampah_9')->nullable();
			
			$table->smallInteger('total_score');
			$table->string('conclusion');
			
            $table->string('diinspeksi_oleh_1')->nullable();
            $table->string('diinspeksi_oleh_2')->nullable();
            $table->string('diinspeksi_oleh_3')->nullable();
            $table->string('mengetahui')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FM_SHE_048_INSPEKSI_CATERING');
    }
};
