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
        Schema::create('cpm_m_obj_category', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 60);
            $table->string('created_by', 20)->nullable();
            $table->string('updated_by', 20)->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpm_m_obj_category');
    }
};
