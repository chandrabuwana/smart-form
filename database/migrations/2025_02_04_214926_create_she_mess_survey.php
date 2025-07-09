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
        Schema::create('she_mess_survey', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->unique();
            $table->string('site_name');
            $table->string('work_location');
            $table->string('department');
            $table->string('shift');
            $table->integer('inspector_count');
            $table->date('survey_date');
            $table->json('checklist_items');
            $table->text('keterangan')->nullable();
            $table->text('risk_description')->nullable();
            $table->text('improvement_action')->nullable();
            $table->text('done_by')->nullable();
            $table->date('completion_date')->nullable();

            // Inspection Information
            $table->string('inspected_by_name')->nullable();
            $table->string('inspected_by_nik')->nullable();
            $table->date('inspection_date')->nullable();

            $table->string('inspected_by2_name')->nullable();
            $table->string('inspected_by2_nik')->nullable();
            $table->date('inspection_date2')->nullable();

            $table->string('inspected_by3_name')->nullable();
            $table->string('inspected_by3_nik')->nullable();
            $table->date('inspection_date3')->nullable();

            $table->string('acknowledged_by_name')->nullable();
            $table->string('acknowledged_by_nik')->nullable();
            $table->date('acknowledgment_date')->nullable();

            // Individual approval statuses
            $table->enum('inspected_by_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('inspected_by2_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('inspected_by3_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('acknowledged_by_status', ['pending', 'approved', 'rejected'])->default('pending');

            // Overall approval status
            $table->enum('approval_status', ['pending', 'in_progress', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('she_mess_survey');
    }
};
