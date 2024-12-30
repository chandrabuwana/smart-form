<?php

namespace Database\Seeders;

use App\Models\TrainingKategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingKategoriSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // GAP KOMPETENSI
        // PROGRAM FRESH GRADUATED
        // TRAINING
        // SERTIFIKASI
        // BKN TRAINING

        $data = [
            ['code' => '', 'nama' => '-'],
            ['code' => 'GAP_KOMPETENSI', 'nama' => 'GAP KOMPETENSI'],
            ['code' => 'PROGRAM_FRESH_GRADUATED', 'nama' => 'PROGRAM FRESH GRADUATED'],
            ['code' => 'TRAINING', 'nama' => 'TRAINING'],
            ['code' => 'SERTIFIKASI', 'nama' => 'SERTIFIKASI'],
            ['code' => 'BKN_TRAINING', 'nama' => 'BUKAN TRAINING'],
        ];

        foreach ($data as $value) {
            TrainingKategori::create($value);
        }
    }
}
