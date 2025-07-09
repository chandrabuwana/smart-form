<?php

namespace Database\Seeders;

use App\Models\MOfflineOnline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MOfflineOnlineSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 0, 'nama' => 'Online'],
            ['id' => 1, 'nama' => 'Offline'],
            ['id' => 2, 'nama' => 'Online & Offline'],
        ];

        foreach ($data as $value) {
            MOfflineOnline::create($value);
        }
    }
}
