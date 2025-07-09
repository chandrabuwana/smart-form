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
        Schema::create('she_coal_getting', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->nullable();
            $table->date('inspection_date');
            $table->string('location');
            $table->string('area_pic'); // Penanggung jawab area
            
            // Checklist items as JSON
            $table->json('checklist_items')->nullable();

            // status
            $table->boolean('isActive')->default(true);
            
            // Signatures
            $table->string('created_by_name')->nullable();
            $table->string('created_by_nik')->nullable();
            $table->string('created_signature')->nullable();
            $table->string('acknowledged_by_name')->nullable();
            $table->string('acknowledged_by_nik')->nullable();
            $table->string('acknowledged_signature')->nullable();
            $table->timestamp('acknowledged_at')->nullable();

            // Approval Status
            $table->enum('approval_status', ['need approval', 'approved', 'reject'])->default('need approval');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('she_coal_getting');
    }
};
