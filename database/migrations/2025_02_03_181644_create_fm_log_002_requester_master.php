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
