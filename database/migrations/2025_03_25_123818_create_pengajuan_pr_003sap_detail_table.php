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
        Schema::create('pengajuan_pr_003sap_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_pr_003sap_id')->constrained('pengajuan_pr_003sap')->onDelete('cascade');
            $table->integer('item_of_requisition')->nullable();
            $table->string('part_number')->nullable();
            $table->string('material_code')->nullable();
            $table->string('short_text')->nullable();
            $table->integer('qty_requested')->nullable();
            $table->string('uom')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('plant')->nullable();
            $table->string('storage')->nullable();
            $table->string('requisitioner')->nullable();
            $table->string('req_tracking_number')->nullable();
            $table->string('purchasing_group')->nullable();
            $table->string('valuation_price')->nullable();
            $table->date('release_date')->nullable();
            $table->string('cost_center')->nullable();
            $table->string('gl_account')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_pr_003sap_detail');
    }
};
