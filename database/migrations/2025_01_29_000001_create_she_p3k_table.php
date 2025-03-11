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

            // Approval Information
            $table->string('inspector_1')->nullable();
            $table->string('inspector_1_signature')->nullable();
            $table->date('inspector_1_date')->nullable();
            
            $table->string('inspector_2')->nullable();
            $table->string('inspector_2_signature')->nullable();
            $table->date('inspector_2_date')->nullable();
            
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_signature')->nullable();
            $table->date('supervisor_date')->nullable();
            
            $table->string('dh_name')->nullable();
            $table->string('dh_signature')->nullable();
            $table->date('dh_date')->nullable();
            
            $table->string('she_name')->nullable();
            $table->string('she_signature')->nullable();
            $table->date('she_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('she_p3k');
    }
};
