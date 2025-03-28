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
        Schema::create('prod_a2b_baru', function (Blueprint $table) {
            $table->increments('id');
            $table->string('doc_number')->unique();
            $table->string('nama_operator');
            $table->string('nrp');
            $table->string('tanggal');
            $table->string('shift');
            $table->string('lokasi');
            $table->string('type_nounit');
            $table->string('hmawal1');
            $table->string('hmawal2');
            $table->string('hmakhir1');
            $table->string('hmakhir2');
            $table->string('kondisi_tubuh');
            $table->string('operator');
            $table->string('pengawas');
            $table->string('status_operator');
            $table->string('status_pengawas');
            $table->string('question1');
            $table->string('question2');
            $table->string('question3');
            $table->string('question4');
            $table->string('question5');
            $table->string('question6');
            $table->string('question7');
            $table->string('question8');
            $table->string('question9');
            $table->string('question10');
            $table->string('question11');
            $table->string('question12');
            $table->string('deskripsi');
            $table->string('kondisi1');
            $table->string('kondisi2');
            $table->string('kondisi3');
            $table->string('kondisi4');
            $table->string('kondisi_unit');
            $table->string('catatan_unit');
            $table->string('catatan_pengawas');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prod_a2b_baru');
    }
};
