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
        Schema::create('ppm_dh24_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ppm_dh24_id')->nullable();

            // Engine
            $table->text('eng_actual')->nullable();
            $table->text('eng_correction_made')->nullable();
            $table->text('eng_result')->nullable();
            $table->text('eng_pr')->nullable();
            $table->text('eng_taggal')->nullable();
            $table->text('eng_remark')->nullable();

            // Hydraulic
            $table->text('hyd_actual')->nullable();
            $table->text('hyd_correction_made')->nullable();
            $table->text('hyd_result')->nullable();
            $table->text('hyd_pr')->nullable();
            $table->text('hyd_taggal')->nullable();
            $table->text('hyd_remark')->nullable();

            // Work Order
            $table->text('wo_actual')->nullable();
            $table->text('wo_correction_made')->nullable();
            $table->text('wo_result')->nullable();
            $table->text('wo_pr')->nullable();
            $table->text('wo_taggal')->nullable();
            $table->text('wo_remark')->nullable();

            // Final
            $table->text('fin_actual')->nullable();
            $table->text('fin_correction_made')->nullable();
            $table->text('fin_result')->nullable();
            $table->text('fin_pr')->nullable();
            $table->text('fin_taggal')->nullable();
            $table->text('fin_remark')->nullable();

            $table->string('doc_num_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppm_dh24_detail');
    }
};
