<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gs_inspeksi_tmk_pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->string('pertanyaan', 255);
            $table->string('category', 20);
            $table->timestamp('created_at')->default(DB::raw('GETDATE()'));
            $table->string('created_by', 20)->nullable();
            $table->timestamp('updated_at')->default(DB::raw('GETDATE()'));
            $table->string('updated_by', 20)->nullable();
            $table->integer('urutan_pertanyaan');
        });

        DB::statement("
            EXEC sp_addextendedproperty
                'MS_Description', 'MESS, TOILET, KANTOR',
                'SCHEMA', 'dbo',
                'TABLE', 'gs_inspeksi_tmk_pertanyaan',
                'COLUMN', 'category'
        ");

        DB::table('gs_inspeksi_tmk_pertanyaan')->insert([
            // MESS
            ['pertanyaan' => 'Apakah tersedia tempat sampah dengan kondisi baik?', 'category' => 'MESS', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 1],
            ['pertanyaan' => 'Apakah tempat tidur bersih dan rapi?', 'category' => 'MESS', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 2],
            ['pertanyaan' => 'Apakah sprei/kasur tidak kotor dan tidak robek?', 'category' => 'MESS', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 3],
            ['pertanyaan' => 'Apakah tersedia sabun mandi dan pasta gigi?', 'category' => 'MESS', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 4],
            ['pertanyaan' => 'Apakah kondisi kamar mandi bersih dan tidak bau?', 'category' => 'MESS', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 5],
            ['pertanyaan' => 'Apakah tersedia air bersih di kamar mandi?', 'category' => 'MESS', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 6],
            ['pertanyaan' => 'Apakah tersedia ventilasi udara yang baik di kamar tidur?', 'category' => 'MESS', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 7],
            ['pertanyaan' => 'Apakah tersedia penerangan yang cukup di kamar tidur?', 'category' => 'MESS', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 8],
            ['pertanyaan' => 'Apakah kondisi lemari pakaian dalam keadaan baik?', 'category' => 'MESS', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 9],
            ['pertanyaan' => 'Apakah tersedia alat pembersih seperti sapu, pengki, dan pel?', 'category' => 'MESS', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 10],

            // TOILET
            ['pertanyaan' => 'Apakah kondisi toilet bersih dan tidak bau?', 'category' => 'TOILET', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 1],
            ['pertanyaan' => 'Apakah tersedia air bersih yang cukup?', 'category' => 'TOILET', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 2],
            ['pertanyaan' => 'Apakah tersedia sabun cuci tangan?', 'category' => 'TOILET', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 3],
            ['pertanyaan' => 'Apakah tersedia alat kebersihan toilet (sikat, pel, dsb)?', 'category' => 'TOILET', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 4],
            ['pertanyaan' => 'Apakah tersedia tempat sampah di toilet?', 'category' => 'TOILET', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 5],
            ['pertanyaan' => 'Apakah kondisi lantai toilet tidak licin?', 'category' => 'TOILET', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 6],
            ['pertanyaan' => 'Apakah ventilasi toilet berfungsi dengan baik?', 'category' => 'TOILET', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 7],
            ['pertanyaan' => 'Apakah terdapat penerangan yang cukup di toilet?', 'category' => 'TOILET', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 8],
            ['pertanyaan' => 'Apakah toilet dapat dikunci dari dalam?', 'category' => 'TOILET', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 9],
            ['pertanyaan' => 'Apakah kloset/toilet tidak mampet dan dapat digunakan dengan baik?', 'category' => 'TOILET', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 10],

            // KANTOR
            ['pertanyaan' => 'Apakah tersedia alat pemadam api ringan (APAR)?', 'category' => 'KANTOR', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 1],
            ['pertanyaan' => 'Apakah kondisi kantor bersih dan rapi?', 'category' => 'KANTOR', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 2],
            ['pertanyaan' => 'Apakah terdapat ventilasi atau sirkulasi udara yang baik?', 'category' => 'KANTOR', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 3],
            ['pertanyaan' => 'Apakah terdapat penerangan yang cukup?', 'category' => 'KANTOR', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 4],
            ['pertanyaan' => 'Apakah meja kerja dalam keadaan rapi dan bersih?', 'category' => 'KANTOR', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 5],
            ['pertanyaan' => 'Apakah tersedia tempat sampah di dalam kantor?', 'category' => 'KANTOR', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 6],
            ['pertanyaan' => 'Apakah tersedia alat kebersihan kantor (sapu, pel, dll)?', 'category' => 'KANTOR', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 7],
            ['pertanyaan' => 'Apakah tersedia air minum yang cukup?', 'category' => 'KANTOR', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 8],
            ['pertanyaan' => 'Apakah tersedia kotak P3K?', 'category' => 'KANTOR', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 9],
            ['pertanyaan' => 'Apakah semua peralatan kerja dalam kondisi baik?', 'category' => 'KANTOR', 'created_by' => 'system', 'updated_by' => 'system', 'urutan_pertanyaan' => 10],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('gs_inspeksi_tmk_pertanyaan');
    }
};
