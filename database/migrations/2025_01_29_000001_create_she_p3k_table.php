<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('she_p3k', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->unique();
            $table->date('inspection_date');
            $table->string('location');
            $table->json('items_data')->nullable();
            $table->string('created_by');
            $table->string('supervisor')->nullable();
            $table->string('dh')->nullable();
            $table->string('she')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('she_p3k');
    }
};
