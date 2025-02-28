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
        Schema::create('prod_form_checker', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->unique();
            $table->string('tanggal');
            $table->string('alat_muat');
            $table->string('start_loading');
            $table->string('stop_loading');
            $table->string('shift');
            $table->string('name_operator_leader');
            $table->string('pic_area');
            $table->string('alat_angkut');
            $table->string('nama_operator');
            $table->string('time');
            $table->string('time_operation');
            $table->string('ritasi');
            $table->string('material');
            $table->string('kendala');
            $table->string('waktu_kendala');
            $table->string('keterangan');
            $table->string('loading_point');
            $table->string('jarak');
            $table->string('time_loading');
            $table->string('disposal');
            $table->string('checker');
            $table->string('pengawas');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prod_form_checker');
    }
};
