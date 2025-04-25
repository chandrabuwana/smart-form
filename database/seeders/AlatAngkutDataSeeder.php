<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlatAngkutDataSeeder extends Seeder {
    /**
    * Run the database seeds.
    */

    public function run(): void {
        DB::table( 'alat_angkut_data' )->insert( [
            [ 'no_lambung' => 'X167', 'site' => 'AGM', 'model' => 'PC1250SP-8R' ],
            [ 'no_lambung' => 'X9220', 'site' => 'AGM', 'model' => 'PC850-SE' ],
            [ 'no_lambung' => 'X9408', 'site' => 'AGM', 'model' => 'PC1250SP-11R' ],
            [ 'no_lambung' => 'X9307', 'site' => 'AGM', 'model' => 'XCMG 1250' ],
            [ 'no_lambung' => 'X9476', 'site' => 'AGM', 'model' => 'E6550F' ],
            [ 'no_lambung' => 'X9372', 'site' => 'AGM', 'model' => 'R210W-9S' ],
            [ 'no_lambung' => 'X9205', 'site' => 'BAYAN', 'model' => 'PC2000-8' ],
            [ 'no_lambung' => 'X9500', 'site' => 'BAYAN', 'model' => 'PC2000-11R' ],
            [ 'no_lambung' => 'X9511', 'site' => 'BAYAN', 'model' => 'E6550F' ],
            [ 'no_lambung' => 'CP040', 'site' => 'BAYAN', 'model' => 'RS8200H' ],
            [ 'no_lambung' => 'WT526', 'site' => 'BAYAN', 'model' => 'HD465-7R' ],
            [ 'no_lambung' => 'CT037', 'site' => 'BAYAN', 'model' => 'CT037' ],
            [ 'no_lambung' => 'X165', 'site' => 'BSSR', 'model' => 'PC1250SP-8R' ],
            [ 'no_lambung' => 'X9340', 'site' => 'BSSR', 'model' => 'XE1250' ],
            [ 'no_lambung' => 'HT81016', 'site' => 'BSSR', 'model' => 'CMT 96' ],
            [ 'no_lambung' => 'DT7399', 'site' => 'BSSR', 'model' => 'DFH3250A82' ],
            [ 'no_lambung' => 'MG333', 'site' => 'BSSR', 'model' => 'GR3005T' ],
            [ 'no_lambung' => 'LT023', 'site' => 'BSSR', 'model' => 'ACTROS-4043K' ],
        ] );
    }
}
