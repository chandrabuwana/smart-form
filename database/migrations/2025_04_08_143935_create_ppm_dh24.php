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
        Schema::create('ppm_dh24', function (Blueprint $table) {
            $table->id();
            $table->string('doc_num')->nullable();
            $table->string('unit_model')->nullable();
            $table->string('unit_sn')->nullable();
            $table->string('unit_cn')->nullable();
            $table->string('engine_model')->nullable();
            $table->string('engine_sn')->nullable();
            $table->string('brand')->nullable();
            $table->string('job_site')->nullable();
            $table->string('job_location')->nullable();
            $table->string('at_inspection')->nullable();
            $table->date('date')->nullable();
            $table->string('note')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('validated_by')->nullable();
            $table->integer('delete_status')->nullable();
            $table->string('creator')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppm_dh24');
    }
};
