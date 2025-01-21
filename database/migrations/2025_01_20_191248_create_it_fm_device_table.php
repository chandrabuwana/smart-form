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
        Schema::create('it_fm_device', function (Blueprint $table) {
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

            // User Information
            $table->string('user_name');
            $table->string('user_nik');
            $table->string('user_dept');
            $table->enum('user_site', ['agm', 'mbl', 'mme', 'mas', 'pmss', 'taj', 'bssr', 'tdm', 'msj']);
            $table->string('user_no_asset')->nullable();
            

            // Asset Information
            $table->string('jenis_aset');
            $table->string('tipe_aset');
            $table->string('merk');
            $table->string('model');
            $table->string('processor');
            $table->string('ram');
            $table->string('hdd');
            $table->string('vga');
            $table->string('os');

            // Hardware Condition
            $table->enum('case_casing_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('touchscreen_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('mouse_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('adaptor_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('monitor_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('keyboard_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('port_usb_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('webcam_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('display_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('speaker_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('fan_processor_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('wireless_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('mic_condition', ['baik', 'rusak'])->default('rusak');
            $table->enum('battery_condition', ['baik', 'rusak'])->default('rusak');

            // Software Condition
            $table->enum('has_ccleaner', ['ada', 'tidak'])->default('tidak');
            $table->enum('has_zoom', ['ada', 'tidak'])->default('tidak');
            $table->enum('has_sap', ['ada', 'tidak'])->default('tidak');
            $table->enum('has_microsoft_office', ['ada', 'tidak'])->default('tidak');
            $table->enum('has_anydesk', ['ada', 'tidak'])->default('tidak');
            $table->enum('has_sisoft', ['ada', 'tidak'])->default('tidak');
            $table->enum('has_erp', ['ada', 'tidak'])->default('tidak');
            $table->enum('has_vnc_remote', ['ada', 'tidak'])->default('tidak');
            $table->enum('has_minning_software', ['ada', 'tidak'])->default('tidak');
            $table->enum('has_pdf_viewer', ['ada', 'tidak'])->default('tidak');
            $table->enum('has_wepresent', ['ada', 'tidak'])->default('tidak');


            // Maintenance Information
            $table->boolean('disk_defragment')->nullable();
            $table->boolean('driver_printer')->nullable();
            $table->boolean('clean_temp_file')->nullable();
            $table->boolean('unused_app')->nullable();
            $table->boolean('scan_antivirus')->nullable();
            $table->boolean('cleaning_fan_internal')->nullable();
            $table->boolean('clean_junk_file')->nullable();
            $table->boolean('brightness_level')->nullable();
            $table->boolean('speaker')->nullable();
            $table->boolean('wifi_connection')->nullable();
            $table->boolean('hdmi')->nullable();


            // Tracking fields
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('it_fm_device');
    }
};
