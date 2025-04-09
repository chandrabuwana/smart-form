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
        Schema::create('objective_competitor', function (Blueprint $table) {
            $table->bigInteger('id_m_competitor');
            $table->bigInteger('id_m_obj');
            $table->string('nilai')->nullable()->default('0');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->primary(['id_m_competitor', 'id_m_obj']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objective_competitor');
    }
};
