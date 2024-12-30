<?php

namespace Database\Seeders;

use App\Models\JenisApproval;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
