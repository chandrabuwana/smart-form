<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // id int
    // training_komitmen_id int
    // m_training_approval_id int
    // status int
    // keterangan string
    // created_at datetime
    // updated_at datetime
    // created_by string
    // updated_by string
    public function up(): void
    {
        Schema::create('training_komitmen_approval', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('training_komitmen_id')->nullable();
            $table->bigInteger('m_training_approval_id');
            $table->integer('status')->default(0)->nullable();
            $table->integer('approval_order')->nullable();
            $table->string('jenis');
            $table->string('keterangan')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('updated_by', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trining_komitmen_approval');
    }
};
