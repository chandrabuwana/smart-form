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
        Schema::create('FM_LOG_002_REQUESTER_MASTER_DETAIL', function (Blueprint $table) {
            $table->string('id_req_master');
            $table->string('status_req')->nullable();
            $table->string('kode_master');
            $table->string('part_name');
            $table->string('uom');
            $table->string('part_number');
            $table->string('brand');
            $table->string('gen_itc');
            $table->string('model');
            $table->string('compartement');
            $table->string('fff_class');
            $table->string('plan_material_status');
            $table->string('mrp_type');
            $table->string('scrap');
            $table->string('material_type');
            $table->string('material_group');
            $table->string('valuation_class');
            $table->string('req')->nullable();
            $table->date('date')->nullable();
            $table->string('site')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FM_LOG_002_REQUESTER_MASTER_DETAIL');
    }
};
