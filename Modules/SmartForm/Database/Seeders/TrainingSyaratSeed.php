<?php

namespace Database\Seeders;

use App\Models\TrainingSyarat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingSyaratSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Masa Kerja', 'nilai' => '1', 'operasi' => '>=', 'uom' => 'tahun'],
            ['nama' => 'Umur', 'nilai' => null, 'operasi' => null, 'uom' => 'tahun'],
            ['nama' => 'Pendidikan', 'nilai' => null, 'operasi' => null, 'uom' => null],
            ['nama' => 'Nilai', 'nilai' => null, 'operasi' => null, 'uom' => null],
            ['nama' => 'Tinggi Badan', 'nilai' => null, 'operasi' => null, 'uom' => 'cm'],
            ['nama' => 'Jurusan', 'nilai' => null, 'operasi' => null, 'uom' => null],
            ['nama' => 'Raport', 'nilai' => null, 'operasi' => null, 'uom' => null],
            ['nama' => 'ATR', 'nilai' => null, 'operasi' => null, 'uom' => null],
        ];

        foreach ($data as $value) {
            TrainingSyarat::create($value);
        }
    }
}
