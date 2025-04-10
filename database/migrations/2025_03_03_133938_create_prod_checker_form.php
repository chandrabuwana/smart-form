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
        Schema::create('prod_checker_form', function (Blueprint $table) {
            $table->id();
            $table->string('doc_num')->unique();
            $table->string('tanggal');
            $table->string('alat_muat');
            $table->string('start_loading');
            $table->string('stop_loading');
            $table->string('shift');
            $table->string('status');
            $table->string('operator_leader');
            $table->string('pic_area');
            $table->string('alat_angkut');
            $table->string('nama_operator');
            $table->string('time_detail1');
            $table->string('time_detail2');
            $table->string('time_detail3');
            $table->string('time_detail4');
            $table->string('time_detail5');
            $table->string('time_detail6');
            $table->string('time_detail7');
            $table->string('time_detail8');
            $table->string('time_detail9');
            $table->string('time_detail10');
            $table->string('time_detail11');
            $table->string('time_detail12');
            $table->string('material');
            $table->string('kendala');
            $table->string('waktu_mulai');
            $table->string('waktu_selesai');
            $table->string('keterangan');
            $table->string('loading_point');
            $table->string('jarak');
            $table->string('disposal');
            $table->string('checker');
            $table->string('pengawas');
			$table->string('site')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prod_checker_form');
    }
};
