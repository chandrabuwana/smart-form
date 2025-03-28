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
        Schema::create('prod_kalibrasi_ct', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->unique();
            //HAULER
            $table->text('nama_operator_loader_hauler');
            $table->text('nomor_exca_hauler');
            $table->text('nama_disposal_hauler');
            $table->text('jumlah_hauler_digunakan_hauler');
            $table->text('tanggal_hauler');
            $table->text('shift_hauler');
            $table->text('alat_support_hauler');
            $table->text('material_hauler');
            $table->text('ket_front_hauler');
            $table->text('ket_jalan_hauler');
            $table->text('ket_grade_hauler');
            $table->text('ket_disposal_hauler');
            $table->text('no_loader_hauler');
            $table->text('nomor_dtht_hauler');
            $table->text('nama_operator_hauler');
            $table->text('waktu_antri_hauler');
            $table->text('jarak_hauling_hauler');
            $table->text('meninggalkan_front_hauler');
            $table->text('cycle_timer_hauler');
            $table->text('jumlah_bucket_hauler');

            //LOADER
            $table->text('tanggal_loader');
            $table->text('shift_loader');
            $table->text('nama_operator_loader');
            $table->text('nomor_exca_loader');
            $table->text('lokasi_loader');
            $table->text('jumlah_hauler_digunakan_loader');
            $table->text('jarak_hauling_loader');
            $table->text('kondisi_front_loader');
            $table->text('alat_support_loader');
            $table->text('cuaca_loader');
            $table->text('rata_rata_loader');
            $table->text('no_loader');
            $table->text('jenis_material_loader');
            $table->text('nomor_cmtdt_loader');
            $table->text('digging_loader');
            $table->text('swing_isi_loader');
            $table->text('load_loader');
            $table->text('swing_kosong_loader');
            $table->text('total_pengisian_loader');
            $table->text('durasi_loader');
            $table->text('reason_loader');

            //DOZER
            $table->text('tanggal_dozer');
            $table->text('shift_dozer');
            $table->text('nama_operator_dozer');
            $table->text('nomor_lambung_dozer');
            $table->text('lokasi_dozing_dozer');
            $table->text('material_dozer');
            $table->text('jarak_dozing_dozer');
            $table->text('kondisi_area_kerja_dozer');
            $table->text('alat_support_dozer');
            $table->text('cuaca_dozer');
            $table->text('no_dozer');
            $table->text('dozing_dozer');
            $table->text('reverse_dozer');
            $table->text('gear_shifting_dozer');
            $table->text('total_dozer');
            $table->text('cm_dozer');
            $table->text('jarak_dozer');
            $table->text('durasi_dozer');
            $table->text('reason_dozer');

            //Approval Needs
            $table->text('dibuat_hauler');
            $table->text('mengetahui_hauler');
            $table->text('status_dibuat_hauler');
            $table->text('status_mengetahui_hauler');
            $table->text('jabatan_dibuat_hauler');
            $table->text('jabatan_mengetahui_hauler');

            $table->text('dibuat_loader');
            $table->text('mengetahui_loader');
            $table->text('status_dibuat_loader');
            $table->text('status_mengetahui_loader');
            $table->text('jabatan_dibuat_loader');
            $table->text('jabatan_mengetahui_loader');

            $table->text('dibuat_dozer');
            $table->text('mengetahui_dozer');
            $table->text('status_dibuat_dozer');
            $table->text('status_mengetahui_dozer');
            $table->text('jabatan_dibuat_dozer');
            $table->text('jabatan_mengetahui_dozer');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prod_kalibrasi_ct');
    }
};
