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
        Schema::create('it_fm_router', function (Blueprint $table) {
            $table->id();

            $table->string('doc_number')->nullable();
            $table->integer('revision')->default(0);
            // Teknisi Information
            $table->string('nama');
            $table->string('nik');
            $table->string('dept');
            $table->enum('site', ['agm', 'mbl', 'mme', 'mas', 'pmss', 'taj', 'bssr', 'tdm', 'msj']);

            // Asset Information
            $table->string('no_asset')->nullable();
            $table->string('jenis_aset');
            $table->string('merk');
            $table->string('model');

            // Hardware Condition
            $table->enum('router_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('antena_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('cable_condition', ['baik', 'rusak'])->default('rusak');

            // Maintenance Information
            $table->boolean('dust_cleaner_check')->nullable();
            $table->boolean('restart_router_check')->nullable();
            $table->boolean('port_check')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('it_fm_router');
    }
};
