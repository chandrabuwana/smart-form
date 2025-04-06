<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lgmg_pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->text('pertanyaan');
            $table->string('category');
            $table->integer('urutan_pertanyaan');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });

        $pertanyaanPerKategori = [
            'KABIN' => [
                'Check kondisi kaca spion',
                'Check kondisi kaca depan',
                'Check kondisi kaca kamera',
                'Check kondisi body',
                'Check kondisi pintu',
                'Check kondisi rubber wiper',
                'Check kondisi Tangga Naik',
                'Check kondisi dump & Hand brake',
                'Check kondisi Handle Reatarder',
                'Check kondisi Handle Transmisi',
            ],
            'ELECTRIK' => [
                'Check Lampu Depan',
                'Check Lampu Belakang',
                'Check sensor Dump',
                'Check Lampu Rem',
                'Check Lampu Kabin',
                'Check Lampu Rotary',
                'Check Lampu Kabut',
                'Check Fungsi Signal (Sign)',
                'Check instrument Panel',
            ],
            'ENGINE' => [
                'Check Level Oli engine',
                'Check engine cooler',
                'Check radiator',
                'Check after cooler',
                'Check kebocoran ; oil, Solar, Air',
            ],
            'SAFETY_TOOLS' => [
                'Check Kelengkapan Apar',
                'Check Kelengkapan kotak P3K',
                'Check Traffic Cone',
                'Check Ganjal Ban',
            ],
            'SUSPENSION_AND_AXEL' => [
                'Check kondisi spring front axel 1',
                'Check kondisi spring front axel 2',
                'Check kondisi spring rear axel',
                'Check kondisi torque road',
                'Check kondisi shaft axel',
                'Check bolt propeler shaft',
                'Check joint propeler shaft',
                'Check kondisi shok absober',
                'Check Bolt for Axel & final drive',
                'Check kebocoran oil final drive',
                'Check Kebocoran Diffrectial',
                'Check Keretakan Diffrectial',
            ],
            'HYDROLIK_SYSTEM_DUMP' => [
                'Check Level Oli hyd',
                'Check kebocoran oil dump',
                'Check bolt and baut for dump',
                'Check kondisi vesel',
            ],
            'TRANSMISSION' => [
                'Check kebocoran oil transmission',
                'Check Baut Transmisi',
                'Check kebocoran oil tranmisi',
                'Check level oil tranmisi',
            ],
            'WHEEL_AND_BREAK' => [
                'Check Kebocoran Angin Rem',
                'Check Kondisi hause cyember',
                'Check Kebocoran Oil Seal Wheel Hub',
                'Check Wheel Kondisi',
                'Check Funsion Break',
            ],
            'ITEM_LAIN' => [
                'Check kamera mundur',
                'Check rock ijektor',
            ]
        ];

        $urutan = 1;
        foreach ($pertanyaanPerKategori as $kategori => $pertanyaanList) {
            foreach ($pertanyaanList as $pertanyaan) {
                DB::table('lgmg_pertanyaan')->insert([
                    'pertanyaan' => $pertanyaan,
                    'category' => $kategori,
                    'urutan_pertanyaan' => $urutan++,
                    'created_by' => 'admin',
                    'updated_by' => 'admin',
                    'created_at' => DB::raw('GETDATE()'),
                    'updated_at' => DB::raw('GETDATE()'),
                ]);
            }
            $urutan = 1;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lgmg_pertanyaan');
    }
};
