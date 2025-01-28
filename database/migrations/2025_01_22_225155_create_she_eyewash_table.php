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
            
            // Approval information
            $table->string('created_by');
            $table->string('checked_by')->nullable();
            $table->timestamp('checked_at')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            
            // Supervisor and DH information
            $table->string('supervisor')->nullable();
            $table->string('dh')->nullable();
            $table->string('dh_terkait')->nullable();
            
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
