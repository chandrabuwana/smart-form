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
        Schema::create('gs_inspeksi_tmk_jawaban', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_doc')->nullable();
            $table->string('nama_site')->nullable();
            $table->string('dept')->nullable();
            $table->string('shift')->nullable();
            $table->string('loker')->nullable();
            $table->integer('jml_ins')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('validated_by')->nullable();
            $table->string('mengetahui')->nullable();
            $table->timestamps(); // created_at & updated_at
            $table->integer('delete_status')->nullable();
            $table->string('status')->nullable();
            $table->string('creator')->nullable();
            $table->string('doc_num')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gs_inspeksi_tmk_jawaban');
    }
};
