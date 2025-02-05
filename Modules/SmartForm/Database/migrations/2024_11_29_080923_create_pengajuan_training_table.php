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
        Schema::create('pengajuan_training', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('m_training_id');
            $table->string('no_document')->nullable();
            $table->integer('jml_orang_plan')->default(0);
            $table->integer('jml_orang_act')->default(0);
            $table->float('biaya_plan')->default(0);
            $table->float('biaya_act')->default(0);
            $table->year('tahun');
            $table->tinyInteger('bulan');
            $table->integer('status')->nullable()->default(0);
            $table->timestamps();
            $table->string('created_by', 20)->nullable();
            $table->string('updated_by', 20)->nullable();
            // $table->foreign('m_training_id')->on('m_training')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_training');
    }
};
