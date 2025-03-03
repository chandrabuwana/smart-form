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
        Schema::create('cpm_approval', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_m_cpm');
            $table->bigInteger('id_m_approval');
            $table->integer('stts')->default(0);
            $table->string('created_by', 20)->nullable();
            $table->string('updated_by', 20)->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->string('sebagai', 50)->nullable();
            $table->integer('urutan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->foreign('id_m_cpm')->on('cpm_m_form')->references('id');
            $table->foreign('id_m_approval')->on('cpm_m_form_approval')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpm_approval');
    }
};
