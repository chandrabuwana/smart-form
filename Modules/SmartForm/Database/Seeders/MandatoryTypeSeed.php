<?php

namespace Database\Seeders;

use App\Models\MandatoryType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MandatoryTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 0, 'nama' => 'Non Mandatory'],
            ['id' => 1, 'nama' => 'Mandatory']
        ];

        foreach ($data as $value) {
            MandatoryType::create($value);
        }
    }
}
