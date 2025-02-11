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
        Schema::create('unbudget_m_coa', function (Blueprint $table) {
            $table->id();
            $table->string('Code_COA', 50)->nullable()->unique();
            $table->string('CoCd', 50)->nullable();
            $table->string('COA')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unbudget_m_coa');
    }
};
