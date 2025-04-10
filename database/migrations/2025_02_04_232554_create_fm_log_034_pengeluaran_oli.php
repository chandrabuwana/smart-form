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
        Schema::create('FM_LOG_034_PENGELUARAN_OLI', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_dok');
            $table->string('revisi');
            $table->string('tanggal');
            $table->string('halaman');
            $table->string('job_site');
            $table->string('no_lube_station');
            $table->string('shift');
            $table->string('dilaporkan_oleh')->nullable();
            $table->string('diketahui_oleh')->nullable();
			
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
            
            // Tambahkan kolom created_at yang nullable
            $table->date('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FM_LOG_034_PENGELUARAN_OLI');
    }
};
