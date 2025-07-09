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
        Schema::create('lgmg', function (Blueprint $table) {
            $table->id();
            $table->string('doc_num')->unique();
            $table->string('nama_operator')->nullable();
            $table->string('shift')->nullable();
            $table->string('nrp')->nullable();
            $table->decimal('fuel_awal')->nullable();
            $table->decimal('fuel_akhir')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('no_unit')->nullable();
            $table->decimal('km_star')->nullable();
            $table->decimal('km_akhir')->nullable();
            $table->string('hm_star')->nullable();
            $table->string('hm_akhir')->nullable();
            $table->integer('delete_status')->nullable();
            $table->string('creator')->nullable();
            $table->string('status')->nullable();
            $table->text('catatan_rm')->nullable();
            $table->string('diisi_oleh')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lgmg');
    }
};
