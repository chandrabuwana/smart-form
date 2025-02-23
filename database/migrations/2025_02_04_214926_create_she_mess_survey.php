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
            $table->string('inspected_by')->nullable();
            $table->date('inspection_date')->nullable();
            $table->boolean('inspected_signature')->default(false);
            $table->string('inspected_by2')->nullable();
            $table->date('inspection_date2')->nullable();
            $table->boolean('inspected_signature2')->default(false);
            $table->string('inspected_by3')->nullable();
            $table->date('inspection_date3')->nullable();
            $table->boolean('inspected_signature3')->default(false);
            $table->string('acknowledged_by')->nullable();
            $table->date('acknowledgment_date')->nullable();
            $table->boolean('acknowledged_signature')->default(false);
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
