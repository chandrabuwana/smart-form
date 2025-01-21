<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('it_fm_printer', function (Blueprint $table) {
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
            $table->string('no_asset')->nullable();
            $table->string('jenis_aset');
            $table->string('merk');
            $table->string('model');

            // Hardware Condition
            $table->enum('case_casing_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('adaptor_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('kabel_power_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('paper_tray_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('ink_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('cartridge_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('lamp_indicator_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('touchscreen_condition', ['baik', 'rusak'])->default('rusak');

            // Maintenance Information
            $table->boolean('software_update')->nullable();
            $table->boolean('print_test')->nullable();
            $table->boolean('scan_test')->nullable();
            $table->boolean('network_test')->nullable();
            $table->boolean('bluetooth_test')->nullable();
            $table->boolean('cable_test')->nullable();
            $table->boolean('toner_level')->nullable();


            // Tracking fields
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('it_fm_printer');
    }
};
