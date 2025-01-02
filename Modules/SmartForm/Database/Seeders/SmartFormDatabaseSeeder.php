<?php

namespace Modules\SmartForm\Database\Seeders;

use Illuminate\Database\Seeder;

class SmartFormDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /// $this->call(TrainingKategoriSeed::class);
        // $this->call(MTrainingSeed::class);
        // $this->call(TrainingSyaratSeed::class);
        // $this->call(MandatoryTypeSeed::class);
        // $this->call(MOfflineOnlineSeed::class);
        
        $this->call(MApprovalRoleSeed::class);
        $this->call(MPengajuanTrainingStatusSeed::class);
        $this->call(MTrainingApprovalSeed::class);
        $this->call(JenisApprovalSeed::class);
    }
}
