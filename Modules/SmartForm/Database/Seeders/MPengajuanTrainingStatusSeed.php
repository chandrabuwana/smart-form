<?php

namespace Modules\SmartForm\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\SmartForm\App\Models\MPengajuanTrainingStatus;

class MPengajuanTrainingStatusSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['status_id' => 0, 'nama' => 'Pengajuan oleh IC'],
            ['status_id' => -1, 'nama' => 'Dihapus / digantikan dari list pengajuan oleh IC'],
            ['status_id' => 1, 'nama' => 'Disetujui Kabag/Kasi Dept'],//'Diganti oleh Kabag/Kasi Dept Site'],
            ['status_id' => 2, 'nama' => 'Menggantikan nama dari list yg diajukan oleh IC / menambahkan'],
            ['status_id' => -2, 'nama' => 'Tidak setuju mengikuti training'],
            // ['status_id' => 3, 'nama' => 'Disetujui Kabag/Kasi Dept']
        ];

        foreach ($data as $value) {
            MPengajuanTrainingStatus::create($value);
        }
    }
}
