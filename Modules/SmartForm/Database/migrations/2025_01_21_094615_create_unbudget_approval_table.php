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
        Schema::create('unbudget_approval', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('master_id');
            $table->string('NIK', 50)->nullable();
            $table->integer('status')->default(0)->comment('0: not yet, 1: approved, -1: rejected, -2: replaced');
            $table->integer('urutan');
            $table->bigInteger('replacing')->nullable()->comment('diisi ID dari approval jika mengedit PIC approval');
            $table->string('role')->nullable();
            $table->timestamps();
            $table->foreign('master_id')->on('unbudget_master')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unbudget_approval');
    }
};
