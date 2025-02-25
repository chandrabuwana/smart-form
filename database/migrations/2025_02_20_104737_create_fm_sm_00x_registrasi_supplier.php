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
        Schema::create('FM_SM_00X_REGISTRASI_SUPPLIER', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nodok_form');
            $table->string('revisi_form');
            $table->string('tanggal_form');
            $table->string('halaman_form');
			
			/** Informasi umur Vendor */
            $table->string('nama_vendor');
            $table->string('status_pajak_pkp');
            $table->string('no_npwp');
            $table->string('bidang_usaha');
            $table->string('alamat_kantor');
            $table->string('kota');
            $table->string('telepon');
            $table->string('pj_1');
            $table->string('pj_2');
            $table->string('kode_pos');
            $table->string('email');
            $table->string('tlp_1');
            $table->string('tlp_2');
            $table->string('jabatan_1');
            $table->string('jabatan_2');
            $table->string('jabatan_1_email');
            $table->string('jabatan_2_email');
			
			/** Informasi Referensi Transaksi Pembayaran */
            $table->string('metode_pembayaran');
            $table->string('syarat_pembayaran');
            $table->integer('ppn');
            $table->integer('pph');
            $table->string('nama_rekening_1');
            $table->string('nomor_rekening_1');
            $table->string('nama_bank_1');
            $table->string('alamat_bank_1');
			$table->string('nama_rekening_2');
            $table->string('nomor_rekening_2');
            $table->string('nama_bank_2');
            $table->string('alamat_bank_2');
			
			/** Lampiran dokumen */
            $table->string('npwp');
            $table->string('sppkp');
            $table->string('nib_siup');
            $table->string('akta_perusahaan');
            $table->string('pakta_integritas');
            $table->string('kartu_identitas_direktur');
            $table->string('struktur_organisasi');
            $table->string('profile_perusahaan');
            $table->string('surat_lainnya');
			
            $table->string('file_npwp');
            $table->string('file_sppkp');
            $table->string('file_nib_siup');
            $table->string('file_akta_perusahaan');
            $table->string('file_pakta_integritas');
            $table->string('file_ident_direk');
            $table->string('file_struktur_org');
            $table->string('file_profile_per');
            $table->string('file_lain');
			
            $table->string('diisi_oleh');
            $table->string('diterima_oleh');
            $table->string('disetujui_oleh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FM_SM_00X_REGISTRASI_SUPPLIER');
    }
};
