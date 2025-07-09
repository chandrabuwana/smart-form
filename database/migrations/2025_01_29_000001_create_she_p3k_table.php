<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('she_p3k', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->unique();
            $table->date('inspection_date');
            $table->string('location');
            $table->json('items_data')->nullable();
            $table->string('created_by');
            $table->string('created_signature')->nullable();
            $table->date('created_date')->nullable();

            // Approval Information
            $table->string('inspector_1_name')->nullable();
            $table->string('inspector_1_nik')->nullable();
            $table->date('inspector_1_date')->nullable();
            
            $table->string('inspector_2_name')->nullable();
            $table->string('inspector_2_nik')->nullable();
            $table->date('inspector_2_date')->nullable();
            
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_nik')->nullable();
            $table->date('supervisor_date')->nullable();
            
            $table->string('dh_name')->nullable();
            $table->string('dh_nik')->nullable();
            $table->date('dh_date')->nullable();
            
            $table->string('she_name')->nullable();
            $table->string('she_nik')->nullable();
            $table->date('she_date')->nullable();

            // Individual approval statuses
            $table->enum('inspector_1_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('inspector_2_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('supervisor_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('dh_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('she_status', ['pending', 'approved', 'rejected'])->default('pending');

            // Overall approval status
            $table->enum('approval_status', ['pending', 'in_progress', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('she_p3k');
    }
};
