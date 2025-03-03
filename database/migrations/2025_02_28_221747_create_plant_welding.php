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
        Schema::create('plant_welding', function (Blueprint $table) {
            $table->increments('id');
            $table->string('doc_number')->unique();
            $table->enum('site_name', ['agm', 'mbl', 'mme', 'mas', 'pmss', 'taj', 'bssr', 'tdm', 'msj']);
            $table->enum('location', ['Workshop', 'Pitstop', 'Service', 'Truck']);
            $table->string('month');
            $table->enum('jenis_instalasi', ['Instalasi Tetap', 'Troli Portable']);
            $table->string('pemeriksa');
            $table->string('jabatan');
            $table->string('nrp');
            $table->string('atasan');
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
            $table->string('question13');
            $table->string('question14');
            $table->string('question15');
            $table->string('question16');
            $table->string('question17');
            $table->string('question18');
            $table->string('question19');
            $table->string('question20');
            $table->text('catatan1');
            $table->text('catatan2');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant_welding');
    }
};
