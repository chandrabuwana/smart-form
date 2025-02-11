<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\text;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('unbudget_master_dtl', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('master_id');
            $table->string('KodeMaterial')->default('0');
            $table->string('NamaMaterial')->nullable()->default("");
            $table->string('Code_COA', 50);
            $table->string('COA')->nullable();
            $table->float('QTY')->default(0);
            $table->float('HargaSatuan')->default(0);
            $table->text('keterangan')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->tinyInteger('is_deleted')->nullable()->default(0);
            $table->timestamps();
            $table->foreign('master_id')->on('unbudget_master')->references('id');
            $table->foreign('Code_COA')->on('unbudget_m_coa')->references('Code_COA');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unbudget_master_dtl');
    }
};
