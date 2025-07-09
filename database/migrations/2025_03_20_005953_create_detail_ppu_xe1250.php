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
        Schema::create('detail_ppu_xe1250', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number_id');
            $table->string('link_pitch');
            $table->string('link_height');
            $table->string('link_bushing');
            $table->string('grouser_height');
            $table->string('idler');
            $table->string('sprocket');
            $table->string('carrier_roller1');
            $table->string('carrier_roller2');
            $table->string('carrier_roller3');
            $table->string('track_roller');
            $table->string('tem_link_pitch');
            $table->string('tem_link_height');
            $table->string('tem_link_bushing');
            $table->string('tem_grouser_height');
            $table->string('tem_idler');
            $table->string('tem_sprocket');
            $table->string('tem_carrier_roller');
            $table->string('tem_track_roller');

            $table->foreign('doc_number_id')
                ->references('doc_number')
                ->on('ppu_xe1250')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_ppu_xe1250');
    }
};
