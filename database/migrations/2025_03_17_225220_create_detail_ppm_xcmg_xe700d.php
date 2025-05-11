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
        Schema::create('detail_ppm_xcmg_xe700d', function (Blueprint $table) {
            $table->id();
            $table->string('doc_num_id');
            $table->string('eng_actual')->nullable();
            $table->string('eng_correction_made')->nullable();
            $table->string('eng_result')->nullable();        
            $table->string('eng_remark')->nullable();

            $table->string('hyd_actual')->nullable();
            $table->string('hyd_correction_made')->nullable();
            $table->string('hyd_result')->nullable();
            $table->string('hyd_remark')->nullable();

            $table->string('wo_actual')->nullable();
            $table->string('wo_correction_made')->nullable();
            $table->string('wo_result')->nullable();
            $table->string('wo_remark')->nullable();

            $table->string('fin_actual')->nullable();
            $table->string('fin_correction_made')->nullable();
            $table->string('fin_result')->nullable();
            $table->string('fin_remark')->nullable();
            $table->foreign('doc_num_id')->references('doc_num')->on('ppm_xcmg_xe700d')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_ppm_xcmg_xe700d');
    }
};
