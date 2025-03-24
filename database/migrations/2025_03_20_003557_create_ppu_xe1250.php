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
    Schema::create('ppu_xe1250', function (Blueprint $table) {
        $table->id();
        $table->string('doc_number')->unique(); // Ensure doc_number is unique
        $table->string('inspection_date');
        $table->string('unit_model');
        $table->string('sn_unit');
        $table->string('smr_hm');
        $table->string('work_operation');
        $table->string('ground_condition');
        $table->string('condition_area');
        $table->string('content_summary');
        $table->string('status');
        $table->string('creator');
        $table->string('checked_1');
        $table->string('checked_2');
        $table->string('validated');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppu_xe1250');
    }
};
