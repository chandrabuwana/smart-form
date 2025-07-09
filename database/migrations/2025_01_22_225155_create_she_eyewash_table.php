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
        Schema::create('she_eyewash', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->nullable();
            $table->date('inspection_date');
            $table->string('location');
            
            // Monthly inspection data as JSON
            $table->json('monthly_data')->nullable();
            
            // Notes
            $table->text('notes')->nullable();
            
            // Creator information
            $table->string('created_by')->nullable();
            
            // Supervisor and DH information
            $table->string('hygiene_name')->nullable();
            $table->string('hygiene_nik')->nullable();
            $table->timestamp('hygiene_signed_at')->nullable();

            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_nik')->nullable();
            $table->timestamp('supervisor_signed_at')->nullable();

            $table->string('dh_name')->nullable();
            $table->string('dh_nik')->nullable();
            $table->timestamp('dh_signed_at')->nullable();

            $table->string('dh_terkait_name')->nullable();
            $table->string('dh_terkait_nik')->nullable();
            $table->timestamp('dh_terkait_signed_at')->nullable();

            // Individual approval statuses
            $table->enum('hygiene_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('supervisor_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('dh_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('dh_terkait_status', ['pending', 'approved', 'rejected'])->default('pending');

            // Overall approval status
            $table->enum('approval_status', ['pending', 'in_progress', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('she_eyewash');
    }
};
