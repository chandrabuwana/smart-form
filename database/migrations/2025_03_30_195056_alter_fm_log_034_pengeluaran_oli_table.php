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
        Schema::table('fm_log_034_pengeluaran_oli', function (Blueprint $table) {
            // Hapus kolom tanggal
            $table->dropColumn('tanggal');
            
            // Tambahkan kolom created_at yang nullable
            $table->date('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fm_log_034_pengeluaran_oli', function (Blueprint $table) {
            // Kembalikan kolom tanggal (asumsi tipe aslinya adalah date)
            $table->date('tanggal');
            
            // Hapus kolom created_at
            $table->dropColumn('created_at');
        });
    }
};
