<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSheFmAirMinumTable extends Migration
{
    public function up()
    {
        Schema::create('she_air_minum', function (Blueprint $table) {
            $table->id();
            
            // Document Information
            $table->string('doc_number')->nullable();
            $table->date('inspection_date');
            $table->string('revision')->default('01');
            
            // Basic Information
            $table->enum('site_name', ['agm', 'mbl', 'mme', 'mas', 'pmss', 'taj', 'bssr', 'tdm', 'msj']);
            $table->string('department');
            $table->string('shift');
            $table->string('work_location');
            $table->integer('inspector_count')->default(1);
            
            // Checklist Items (Y/N Questions)
            $table->boolean('is_work_area_clean')->default(false);
            $table->boolean('has_scattered_items')->default(false);
            $table->boolean('has_trash_bin')->default(false);
            $table->boolean('has_scattered_trash')->default(false);
            $table->boolean('has_storage_warehouse')->default(false);
            $table->boolean('is_water_filter_regularly_changed')->default(false);
            $table->boolean('is_water_reservoir_cleaned')->default(false);
            $table->boolean('is_distribution_packing_clean')->default(false);
            $table->boolean('is_water_quality_checked_quarterly')->default(false);
            
            // Scoring
            $table->integer('score')->default(0);
            $table->enum('conclusion', ['Very Poor', 'Poor', 'Good', 'Excellent'])->default('Good');
            
            // Notes
            $table->text('notes')->nullable();
            
            // Approval Information
            $table->string('inspector_1')->nullable();
            $table->string('inspector_1_signature')->nullable();
            $table->date('inspector_1_date')->nullable();
            
            $table->string('inspector_2')->nullable();
            $table->string('inspector_2_signature')->nullable();
            $table->date('inspector_2_date')->nullable();
            
            $table->string('inspector_3')->nullable();
            $table->string('inspector_3_signature')->nullable();
            $table->date('inspector_3_date')->nullable();
            
            $table->string('acknowledged_by')->nullable();
            $table->string('acknowledged_by_signature')->nullable();
            $table->date('acknowledged_date')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('she_air_minum');
    }
}
