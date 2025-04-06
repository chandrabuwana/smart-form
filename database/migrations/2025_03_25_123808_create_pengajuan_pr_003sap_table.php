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
        Schema::create('pengajuan_pr_003sap', function (Blueprint $table) {
            $table->id();
            $table->string('doc_num')->nullable();
            $table->string('plant')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('dibuat_oleh')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('creator');
            $table->integer('delete_status');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_pr_003sap');
    }
};
