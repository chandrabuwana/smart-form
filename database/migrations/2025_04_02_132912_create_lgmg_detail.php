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
        Schema::create('lgmg_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('lgmg_id');
            $table->integer('pertanyaan_id');
            $table->string('jawaban')->nullable();
            $table->string('category');
            $table->text('keterangan')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lgmg_detail');
    }
};
