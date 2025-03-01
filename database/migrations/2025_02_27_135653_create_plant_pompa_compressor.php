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
        Schema::create('plant_pompa_compressor', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->unique();
            $table->string('unit_name');
            $table->string('name');
            $table->string('location');
            $table->string('month');
            $table->string('engine_model');
            $table->string('generator_model');
            $table->string('paraf_item');
            $table->string('site');
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
            $table->string('question21');
            $table->string('question22');
            $table->text('catatan');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant_pompa_compressor');
    }
};
