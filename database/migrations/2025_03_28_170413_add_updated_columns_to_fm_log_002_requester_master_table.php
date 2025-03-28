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
            $table->string('updated_by', 255)->nullable()->after('created_by');
            $table->timestamp('updated_at')->nullable()->after('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('FM_LOG_002_REQUESTER_MASTER', function (Blueprint $table) {
            $table->dropColumn(['updated_by', 'updated_at']);
        });
    }
};
