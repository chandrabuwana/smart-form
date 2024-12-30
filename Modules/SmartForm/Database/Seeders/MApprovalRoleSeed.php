<?php

namespace Database\Seeders;

use App\Models\MApprovalRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MApprovalRoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['approval_role' => 1, 'nama' => 'Kasi / Kabag Dept site'],
            ['approval_role' => 2, 'nama' => 'Kasi / Kabag IC site'],
            ['approval_role' => 3, 'nama' => 'PM / People Partner site'],
            ['approval_role' => 4, 'nama' => 'Kadep HO'],
            ['approval_role' => 5, 'nama' => 'Think Thank'],
        ];

        foreach ($data as $value) {
            MApprovalRole::create($value);
        }
    }
}
