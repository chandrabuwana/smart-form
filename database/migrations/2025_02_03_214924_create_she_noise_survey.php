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
            $table->string('site_name');
            $table->integer('inspector_count');
            $table->date('inspection_date');
            $table->date('acknowledgment_date');
            $table->string('inspected_by');
            $table->boolean('inspected_signature')->default(false);
            $table->string('acknowledged_by');
            $table->boolean('acknowledged_signature')->default(false);
            $table->string('work_location');
            $table->string('risk_level')->nullable();
            $table->json('activities');
            $table->json('work_areas')->nullable();
            $table->text('findings_description')->nullable();
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
