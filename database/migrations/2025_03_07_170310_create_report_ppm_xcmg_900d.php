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
        Schema::create('report_ppm_xcmg_900d', function (Blueprint $table) {
            $table->id();
            $table->string('doc_num_id');
            $table->string('eng_actual');
            $table->string('eng_correction_made');
            $table->string('eng_result');
            $table->string('eng_pr');
            $table->string('eng_taggal');
            $table->string('eng_remark');

            $table->string('hyd_actual');
            $table->string('hyd_correction_made');
            $table->string('hyd_result');
            $table->string('hyd_pr');
            $table->string('hyd_taggal');
            $table->string('hyd_remark');

            $table->string('wo_actual');
            $table->string('wo_correction_made');
            $table->string('wo_result');
            $table->string('wo_pr');
            $table->string('wo_taggal');
            $table->string('wo_remark');

            $table->string('fin_actual');
            $table->string('fin_correction_made');
            $table->string('fin_result');
            $table->string('fin_pr');
            $table->string('fin_taggal');
            $table->string('fin_remark');
            $table->foreign('doc_num_id')->references('doc_num')->on('ppm_xcmg_900d')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_ppm_xcmg_900d');
    }
};
