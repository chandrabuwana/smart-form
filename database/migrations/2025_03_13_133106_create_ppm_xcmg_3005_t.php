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
        Schema::create('ppm_xcmg_3005_t', function (Blueprint $table) {
            $table->id();
            $table->string('doc_num')->unique();
            $table->string('unit_model');
            $table->string('unit_sn');
            $table->string('unit_cn');
            $table->string('engine_model');
            $table->string('engine_sn');
            $table->string('att_front');
            $table->string('att_rear');
            $table->string('job_site');
            $table->string('job_location');
            $table->string('at_inspection');
            $table->string('date');
            $table->string('status');
            $table->string('creator');
            $table->string('checked_by');
            $table->string('validated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppm_xcmg_3005_t');
    }
};
