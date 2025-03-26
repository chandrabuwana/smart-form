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
        Schema::create('detail_log_ogc_compliance', function (Blueprint $table) {
            $table->id();
            $table->string('doc_num_id');
            $table->string('week');
            $table->string('date');
            $table->string('lube_station');
            $table->string('lube_truck');
            $table->string('station_comment');
            $table->string('truck_comment');
            $table->string('validator');
            $table->string('checker');
            $table->string('status');
            $table->foreign('doc_num_id')->references('doc_num')->on('log_ogc_compliance')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_log_ogc_compliance');
    }
};
