<?php

namespace Modules\SmartForm\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\SmartForm\App\Models\JenisApproval;

class JenisApprovalSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode' => 'dibuat', 'urutan' => 1],
            ['kode' => 'disetujui', 'urutan' => 2],
            ['kode' => 'diketahui', 'urutan' => 3],
        ];

        foreach ($data as $value) {
            JenisApproval::create($value);
        }
    }
    
}
