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
        Schema::create('it_fm_cctv', function (Blueprint $table) {
            $table->id();
            // Document Info
            $table->string('doc_number')->nullable();
            $table->integer('revision')->default(0);
            $table->date('doc_date')->nullable();
            
            // Teknisi Information
            $table->string('nama');
            $table->string('nik');
            $table->string('dept');
            $table->enum('site', ['agm', 'mbl', 'mme', 'mas', 'pmss', 'taj', 'bssr', 'tdm', 'msj']);

            // Asset Information
            $table->string('no_asset');
            $table->string('jenis_aset');
            $table->string('merk');
            $table->string('model');
            $table->string('area_cctv');

            // Hardware Condition
            $table->enum('camera_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('lens_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('cable_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('storage_cctv_condition', ['baik', 'rusak'])->default('rusak');


            // Maintenance Information
            $table->boolean('cover_area')->nullable();
            $table->boolean('video_quality')->nullable();
            $table->boolean('sound_quality')->nullable();
            $table->boolean('remote_view_nvr')->nullable();
            $table->boolean('remote_playback')->nullable();
            

            // Tracking
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('it_fm_cctv');
    }
};
