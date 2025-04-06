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
        Schema::table('FM_LOG_034_PENGELUARAN_OLI', function (Blueprint $table) {

            $table->string('status_req', 255)
                  ->nullable()
                  ->comment('Status request pengeluaran oli');
                  
            $table->string('remark', 500)
                  ->nullable()
                  ->comment('Keterangan tambahan');
                  
            $table->string('updated_by', 255)
                  ->nullable()
                  ->comment('User yang melakukan update terakhir');
                  
            $table->dateTime('updated_at')
                  ->nullable()
                  ->comment('Waktu update terakhir');
                  
            $table->string('deleted_by', 255)
                  ->nullable()
                  ->comment('User yang melakukan soft delete');
                  
            $table->dateTime('deleted_at')
                  ->nullable()
                  ->comment('Waktu soft delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('FM_LOG_034_PENGELUARAN_OLI', function (Blueprint $table) {
            $table->dropColumn([
                'status_req',
                'remark',
                'updated_by',
                'updated_at',
                'deleted_by',
                'deleted_at'
            ]);
        });
    }
};
