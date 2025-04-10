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
        Schema::create('she_027_ergonomi', function (Blueprint $table) {
            $table->id();
            $table->string('job_position')->nullable(); // Posisi yang dievaluasi (optional)
            $table->date('evaluation_date')->nullable(); // Tanggal (optional)
            $table->integer('total_employee')->nullable(); // Jumlah Pekerja pada pekerjaan ini
            $table->string('employee_name')->nullable(); // Nama Karyawan

            // Audit Information
            $table->string('reviewer_name')->nullable(); // Nama Peninjau
            $table->string('reviewer_nik')->nullable();
            $table->string('paramedic_name')->nullable(); // Paramedic name
            $table->string('paramedic_nik')->nullable();
            $table->string('doctor_name')->nullable(); // Doctor name
            $table->string('doctor_nik')->nullable();
            $table->string('dept_head_name')->nullable(); // Department Head name
            $table->string('dept_head_nik')->nullable();
            $table->date('review_date')->nullable(); // Review date

            // Individual approval statuses
            $table->enum('reviewer_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('paramedic_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('doctor_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('dept_head_status', ['pending', 'approved', 'rejected'])->default('pending');

            // Overall approval status
            $table->enum('approval_status', ['pending', 'in_progress', 'approved', 'rejected'])->default('pending');

            // Checklist Items with Observations
            // Postur Tubuh Janggal / Awkward Posture
            $table->string('organ_tubuh_1')->nullable(); // Body Part for item 1
            $table->string('faktor_resiko_1')->nullable(); // Physical Risk Factor for item 1
            $table->string('kombinasi_dengan_1')->nullable(); // Combination With for item 1
            $table->string('durasi_1')->nullable(); // Duration for item 1
            $table->string('visualisasi_1')->nullable(); // Visualization for item 1
            $table->boolean('item_1')->default(false); // Bekerja dengan tangan diatas kepala
            $table->text('item_1_observation')->nullable(); // Observasi untuk bekerja dengan tangan diatas kepala

            $table->string('organ_tubuh_2')->nullable();
            $table->string('faktor_resiko_2')->nullable();
            $table->string('kombinasi_dengan_2')->nullable();
            $table->string('durasi_2')->nullable();
            $table->string('visualisasi_2')->nullable();
            $table->boolean('item_2')->default(false); // Bekerja dengan leher atau punggung membungkuk
            $table->text('item_2_observation')->nullable(); // Observasi untuk bekerja dengan leher atau punggung membungkuk

            $table->string('organ_tubuh_3')->nullable();
            $table->string('faktor_resiko_3')->nullable();
            $table->string('kombinasi_dengan_3')->nullable();
            $table->string('durasi_3')->nullable();
            $table->string('visualisasi_3')->nullable();
            $table->boolean('item_3')->default(false); // Berjongkok
            $table->text('item_3_observation')->nullable(); // Observasi untuk berjongkok

            $table->string('organ_tubuh_4')->nullable();
            $table->string('faktor_resiko_4')->nullable();
            $table->string('kombinasi_dengan_4')->nullable();
            $table->string('durasi_4')->nullable();
            $table->string('visualisasi_4')->nullable();
            $table->boolean('item_4')->default(false); // Berlutut
            $table->text('item_4_observation')->nullable(); // Observasi untuk berlutut

            // Tenaga Kuat dengan Tangan / High End Force
            $table->string('organ_tubuh_5')->nullable();
            $table->string('faktor_resiko_5')->nullable();
            $table->string('kombinasi_dengan_5')->nullable();
            $table->string('durasi_5')->nullable();
            $table->string('visualisasi_5')->nullable();
            $table->boolean('item_5')->default(false); // Menjepit objek 1kg/2kg
            $table->text('item_5_observation')->nullable(); // Observasi untuk menjepit objek

            $table->string('organ_tubuh_6')->nullable();
            $table->string('faktor_resiko_6')->nullable();
            $table->string('kombinasi_dengan_6')->nullable();
            $table->string('durasi_6')->nullable();
            $table->string('visualisasi_6')->nullable();
            $table->boolean('item_6')->default(false); // Mencengkram objek 5kg
            $table->text('item_6_observation')->nullable(); // Observasi untuk mencengkram objek

            $table->string('organ_tubuh_7')->nullable();
            $table->string('faktor_resiko_7')->nullable();
            $table->string('kombinasi_dengan_7')->nullable();
            $table->string('durasi_7')->nullable();
            $table->string('visualisasi_7')->nullable();
            $table->boolean('item_7')->default(false); // Mengulang pergerakan yang sama
            $table->text('item_7_observation')->nullable(); // Observasi untuk pergerakan berulang

            $table->string('organ_tubuh_8')->nullable();
            $table->string('faktor_resiko_8')->nullable();
            $table->string('kombinasi_dengan_8')->nullable();
            $table->string('durasi_8')->nullable();
            $table->string('visualisasi_8')->nullable();
            $table->boolean('item_8')->default(false); // Mengetik intensif >4 jam
            $table->text('item_8_observation')->nullable(); // Observasi untuk mengetik intensif

            // Dampak Berulang / Repeated Impact
            $table->string('organ_tubuh_9')->nullable();
            $table->string('faktor_resiko_9')->nullable();
            $table->string('kombinasi_dengan_9')->nullable();
            $table->string('durasi_9')->nullable();
            $table->string('visualisasi_9')->nullable();
            $table->boolean('item_9')->default(false); // Menggunakan tangan untuk memukul
            $table->text('item_9_observation')->nullable(); // Observasi untuk penggunaan tangan memukul

            $table->string('organ_tubuh_10')->nullable();
            $table->string('faktor_resiko_10')->nullable();
            $table->string('kombinasi_dengan_10')->nullable();
            $table->string('durasi_10')->nullable();
            $table->string('visualisasi_10')->nullable();
            $table->boolean('item_10')->default(false); // Mengangkat >35kg atau >20kg 10x
            $table->text('item_10_observation')->nullable(); // Observasi untuk mengangkat beban berat

            $table->string('organ_tubuh_11')->nullable();
            $table->string('faktor_resiko_11')->nullable();
            $table->string('kombinasi_dengan_11')->nullable();
            $table->string('durasi_11')->nullable();
            $table->string('visualisasi_11')->nullable();
            $table->boolean('item_11')->default(false); // Mengangkat >5kg dalam 2x/menit
            $table->text('item_11_observation')->nullable(); // Observasi untuk mengangkat beban berulang

            $table->string('organ_tubuh_12')->nullable();
            $table->string('faktor_resiko_12')->nullable();
            $table->string('kombinasi_dengan_12')->nullable();
            $table->string('durasi_12')->nullable();
            $table->string('visualisasi_12')->nullable();
            $table->boolean('item_12')->default(false); // Mengangkat >12kg diatas bahu
            $table->text('item_12_observation')->nullable(); // Observasi untuk mengangkat beban di atas bahu

            // Body Mapping Data
            // JSON column to store all body mapping pain levels
            $table->json('body_mapping_data')->nullable()->comment('JSON data for body mapping pain levels');
            
            // Individual body pain columns for each body part
            for ($i = 0; $i <= 27; $i++) {
                $table->enum('body_pain_' . $i, ['A', 'B', 'C', 'D'])->default('A')->nullable();
            }
            
            // WMSD checkboxes
            $table->boolean('wmsd_bahu_1')->default(false);
            $table->boolean('wmsd_bahu_2')->default(false);
            $table->boolean('wmsd_leher')->default(false);
            $table->boolean('wmsd_punggung_1')->default(false);
            $table->boolean('wmsd_punggung_2')->default(false);
            $table->boolean('wmsd_tangan_kuat_1')->default(false);
            $table->boolean('wmsd_tangan_kuat_2')->default(false);
            $table->boolean('wmsd_tangan_kuat_3')->default(false);
            $table->boolean('wmsd_berulang_1')->default(false);
            $table->boolean('wmsd_berulang_2')->default(false);

            // Observations and Comments
            $table->text('posture_observation')->nullable();
            $table->text('force_observation')->nullable();
            $table->text('impact_observation')->nullable();
            $table->text('vibration_observation')->nullable();
            $table->text('kesimpulan_penilai')->nullable();
            $table->text('komentar_berulang')->nullable();

            // Getaran Sedang s.d. Tinggi pada Tangan-Lengan
            $table->string('organ_tubuh_13')->nullable();
            $table->string('faktor_resiko_13')->nullable();
            $table->string('kombinasi_dengan_13')->nullable();
            $table->string('durasi_13')->nullable();
            $table->string('visualisasi_13')->nullable();
            $table->boolean('item_13')->default(false); // Menggunakan Impact Wrenches
            $table->text('item_13_observation')->nullable(); // Observasi untuk penggunaan impact wrenches

            $table->string('organ_tubuh_14')->nullable();
            $table->string('faktor_resiko_14')->nullable();
            $table->string('kombinasi_dengan_14')->nullable();
            $table->string('durasi_14')->nullable();
            $table->string('visualisasi_14')->nullable();
            $table->boolean('item_14')->default(false); // Menggunakan gerinda
            $table->text('item_14_observation')->nullable(); // Observasi untuk penggunaan gerinda

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('she_027_ergonomi');
    }
};
