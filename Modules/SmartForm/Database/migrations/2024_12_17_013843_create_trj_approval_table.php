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
        Schema::create('trj_approval', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('trj_id')->nullable();
            $table->bigInteger('m_training_approval_id');
            $table->integer('status')->default(0)->nullable();
            $table->integer('approval_order')->nullable();
            $table->string('jenis');
            $table->string('keterangan')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('updated_by', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trj_approval');
    }
};
