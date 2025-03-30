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
        Schema::table('FM_LOG_002_REQUESTER_MASTER', function (Blueprint $table) {
            $table->string('deleted_by', 255)->nullable()->after('created_by');
            $table->date('deleted_at')->nullable()->after('deleted_by');
            $table->string('remark', 500)->nullable()->after('deleted_at');
            $table->string('status_req', 255)->nullable()->after('remark');
            $table->string('kode_plant', 255)->nullable()->after('status_req');
            $table->string('cataloging_id', 255)->nullable()->after('kode_plant');
            $table->date('cataloging_update')->nullable()->after('cataloging_id');
            $table->string('updated_by', 255)->nullable()->after('cataloging_update');
            $table->timestamp('updated_at')->nullable()->after('updated_by');
        });

        Schema::table('FM_LOG_002_REQUESTER_MASTER_DETAIL', function (Blueprint $table) {
            $table->string('purchasing_group', 255)->nullable();
            $table->string('serial_number', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('FM_LOG_002_REQUESTER_MASTER', function (Blueprint $table) {
            $table->dropColumn([
                'deleted_by',
                'deleted_at',
                'remark',
                'status_req',
                'kode_plant',
                'cataloging_id',
                'cataloging_update',
                'updated_by',
                'updated_at'
            ]);
        });

        Schema::table('FM_LOG_002_REQUESTER_MASTER_DETAIL', function (Blueprint $table) {
            $table->dropColumn(['purchasing_group', 'serial_number']);
        });
    }
};
