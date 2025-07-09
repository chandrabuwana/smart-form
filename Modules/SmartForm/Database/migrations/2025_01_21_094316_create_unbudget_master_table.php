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
        Schema::create('unbudget_master', function (Blueprint $table) {
            $table->id();
            $table->string('NoDocument')->unique();
            $table->text('strategi')->nullable();
            $table->text('ekonomi')->nullable();
            $table->text('finance')->nullable();
            $table->text('technology')->nullable();
            $table->text('operation')->nullable();
            $table->string('tempat')->nullable();
            $table->string('KodeST', 20)->nullable();
            $table->string('KodeDP', 20)->nullable();
            $table->date('tanggal')->nullable();
            $table->integer('status')->default(0)->comment('0: baru submit, -1: di reject, 1: approve');
            $table->string('created_by', 20)->nullable();
            $table->string('created_by_name')->nullable();
            $table->string('updated_by', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unbudget_master');
    }
};
