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
        Schema::create('FM_LOG_002_REQUESTER_MASTER', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_dok');
            $table->string('site');
            $table->date('created_at');
            $table->string('created_by');
            $table->string('disetujui_oleh');
            $table->string('diproses_oleh')->nullable();
            $table->string('diketahui_oleh')->nullable();
			
			// $table->string('deleted_by', 255)->nullable()->after('created_by');
            // $table->date('deleted_at')->nullable()->after('deleted_by');
            // $table->string('remark', 500)->nullable()->after('deleted_at');
            // $table->string('status_req', 255)->nullable()->after('remark');
            // $table->string('kode_plant', 255)->nullable()->after('status_req');
            // $table->string('cataloging_id', 255)->nullable()->after('kode_plant');
            // $table->date('cataloging_update')->nullable()->after('cataloging_id');
            // $table->string('updated_by', 255)->nullable()->after('cataloging_update');
            // $table->timestamp('updated_at')->nullable()->after('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FM_LOG_002_REQUESTER_MASTER');
    }
};
