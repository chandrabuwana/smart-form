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
        Schema::create('prod_anak_asuh_monitoring', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->unique();
            $table->string('name');
            $table->string('nik');
            $table->string('jabatan');
            $table->string('departemen');
            $table->string('created_by');
            $table->string('acknowledged_by');
            $table->text('tanggal_items');
            $table->text('attendance_items');
            $table->text('nama_anak_asuh_items');
            $table->text('review_temuan_items');
            $table->text('disiplin_score_items');
            $table->text('skill_score_items');
            $table->text('attitude_score_items');
            $table->text('shift_items');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prod_anak_asuh_monitoring');
    }
};
