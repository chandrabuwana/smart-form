<?php

namespace Modules\SmartForm\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SmartForm\App\Models\AuthorizedUserIC;

class AuthorizedUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nik' => '1006104'],
            ['nik' => '1019624']
        ];

        foreach ($data as $value) {
            AuthorizedUserIC::create($value);
        }
    }
}
