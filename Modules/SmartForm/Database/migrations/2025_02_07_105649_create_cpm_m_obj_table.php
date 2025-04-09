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
        Schema::create('cpm_m_obj', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_obj_category');
            $table->string('ukuran')->nullable()->default('');
            $table->string('nama', 100);
            $table->string('created_by', 20)->nullable();
            $table->string('updated_by', 20)->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamps();
            $table->foreign('id_obj_category')->on('cpm_m_obj_category')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpm_m_obj');
    }
};
