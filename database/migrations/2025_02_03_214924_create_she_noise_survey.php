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
        Schema::create('she_noise_survey', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->nullable();
            $table->string('revision')->nullable();
            $table->date('survey_date')->nullable();
            $table->string('department');
            $table->string('site_name');
            $table->integer('inspector_count');
            $table->date('inspection_date');
            $table->date('acknowledgment_date');
            $table->string('inspected_by_name');
            $table->string('inspected_by_nik');
            $table->string('acknowledged_by_name');
            $table->string('acknowledged_by_nik');
            $table->string('shift')->nullable();
            $table->string('work_location');
            $table->string('risk_level')->nullable();
            $table->json('activities');
            $table->json('work_areas')->nullable();
            $table->text('findings_description')->nullable();

            // Approval Status
            $table->enum('approval_status', ['need approval', 'approved', 'reject'])->default('need approval');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('she_noise_survey');
    }
};
