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
        Schema::create('cpm_m_form_dtl', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_m_cpm');
            $table->bigInteger('id_m_obj');
            $table->string('UOM')->nullable();
            $table->string('HIG_HIB')->nullable();
            $table->string('plan_b_1')->nullable()->default(0);
            $table->string('act_b_1')->nullable()->default(0);
            $table->string('plan_b_2')->nullable()->default(0);
            $table->string('act_b_2')->nullable()->default(0);
            $table->string('plan_b_3')->nullable()->default(0);
            $table->string('act_b_3')->nullable()->default(0);
            $table->string('plan_b_4')->nullable()->default(0);
            $table->string('act_b_4')->nullable()->default(0);
            $table->string('plan_b_5')->nullable()->default(0);
            $table->string('act_b_5')->nullable()->default(0);
            $table->string('plan_b_6')->nullable()->default(0);
            $table->string('act_b_6')->nullable()->default(0);
            $table->string('plan_b_7')->nullable()->default(0);
            $table->string('act_b_7')->nullable()->default(0);
            $table->string('plan_b_8')->nullable()->default(0);
            $table->string('act_b_8')->nullable()->default(0);
            $table->string('plan_b_9')->nullable()->default(0);
            $table->string('act_b_9')->nullable()->default(0);
            $table->string('plan_b_10')->nullable()->default(0);
            $table->string('act_b_10')->nullable()->default(0);
            $table->string('plan_b_11')->nullable()->default(0);
            $table->string('act_b_11')->nullable()->default(0);
            $table->string('plan_b_12')->nullable()->default(0);
            $table->string('act_b_12')->nullable()->default(0);
            $table->string('plan_q1')->nullable()->default(0);
            $table->string('act_q1')->nullable()->default(0);
            $table->string('plan_q2')->nullable()->default(0);
            $table->string('act_q2')->nullable()->default(0);
            $table->string('plan_q3')->nullable()->default(0);
            $table->string('act_q3')->nullable()->default(0);
            $table->string('plan_q4')->nullable()->default(0);
            $table->string('act_q4')->nullable()->default(0);
            $table->string('plan_yearly')->nullable()->default(0);
            $table->string('act_yearly')->nullable()->default(0);
            $table->string('created_by', 20)->nullable();
            $table->string('updated_by', 20)->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->integer('stts')->default(0);
            $table->timestamps();
            $table->foreign('id_m_cpm')->on('cpm_m_form')->references('id');
            $table->foreign('id_m_obj')->on('cpm_m_obj')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpm_m_form_dtl');
    }
};
