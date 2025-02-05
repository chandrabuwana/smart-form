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
        Schema::create('FM_LOG_034_PENGELUARAN_OLI_DETAIL', function (Blueprint $table) {
            $table->integer('id_peng_oli');
            $table->string('unit');
            $table->string('time');
            $table->string('hm');
            $table->string('jenis');
            $table->string('merk');
            $table->integer('awal');
            $table->integer('akhir');
            $table->integer('qty');
            $table->string('component');
            $table->string('remark');
            $table->string('pic_nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FM_LOG_034_PENGELUARAN_OLI_DETAIL');
    }
};
