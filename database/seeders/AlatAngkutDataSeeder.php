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
            [ 'no_lambung' => 'X167', 'site' => 'AGM', 'model' => 'PC1250SP-8R', 'sn_unit' => 'KMTPC190E02035018', 'model_engine' => 'SAA6D170E-5', 'sn_engine' => 'JY-610075' ],
            [ 'no_lambung' => 'X9220', 'site' => 'AGM', 'model' => 'PC850-SE', 'sn_unit' => 'J10044', 'model_engine' => 'SAA6D170E-5', 'sn_engine' => '615730' ],
            [ 'no_lambung' => 'X9408', 'site' => 'AGM', 'model' => 'PC1250SP-11R', 'sn_unit' => 'HCMDDEF2E00052349', 'model_engine' => 'AA-6HK1X', 'sn_engine' => '6HK1-966923' ],
            [ 'no_lambung' => 'X9307', 'site' => 'AGM', 'model' => 'XCMG 1250', 'sn_unit' => 'VLGE621FHM0608515', 'model_engine' => 'BF6M2012-17T3R/5', 'sn_engine' => '60659639' ],
            [ 'no_lambung' => 'X9476', 'site' => 'AGM', 'model' => 'E6550F', 'sn_unit' => 'VLGE621FTN0608827', 'model_engine' => 'BF6M2012-17T3R/5', 'sn_engine' => '60662327' ],
            [ 'no_lambung' => 'X9372', 'site' => 'AGM', 'model' => 'R210W-9S', 'sn_unit' => 'VLGE621FPN0608831', 'model_engine' => 'BF6M2012-17T3R/5', 'sn_engine' => '60662160' ],
            [ 'no_lambung' => 'X9205', 'site' => 'BAYAN', 'model' => 'PC2000-8', 'sn_unit' => 'VLGE621FCP0609784', 'model_engine' => 'BF6M2012-17T3R/5', 'sn_engine' => '606686354' ],
            [ 'no_lambung' => 'X9500', 'site' => 'BAYAN', 'model' => 'PC2000-11R', 'sn_unit' => 'VLGE621FVP0609793', 'model_engine' => 'BF6M2012-17T3R/5', 'sn_engine' => '60688525' ],
            [ 'no_lambung' => 'X9511', 'site' => 'BAYAN', 'model' => 'E6550F', 'sn_unit' => 'VLGE621FLP0609795', 'model_engine' => 'BF6M2012-17T3R/5', 'sn_engine' => '60685192' ],
            [ 'no_lambung' => 'CP040', 'site' => 'BAYAN', 'model' => 'RS8200H', 'sn_unit' => 'VLGE621FCP0610031', 'model_engine' => 'BF6M2012-17T3R/5', 'sn_engine' => '60709579' ],
            [ 'no_lambung' => 'WT526', 'site' => 'BAYAN', 'model' => 'HD465-7R', 'sn_unit' => '65879', 'model_engine' => 'SAA6D170E-5', 'sn_engine' => '121626' ],
            [ 'no_lambung' => 'CT037', 'site' => 'BAYAN', 'model' => 'CT037', 'sn_unit' => 'CHSDH24HCMB000219', 'model_engine' => 'WD12G250E202', 'sn_engine' => '1121K002077' ],
            [ 'no_lambung' => 'X165', 'site' => 'BSSR', 'model' => 'PC1250SP-8R', 'sn_unit' => 'CHSD32AWHN1008075', 'model_engine' => 'NTA855-C360S10', 'sn_engine' => '41324379' ],
            [ 'no_lambung' => 'X9340', 'site' => 'BSSR', 'model' => 'XE1250', 'sn_unit' => 'CHSDH24HCNC000281', 'model_engine' => 'WP12G290E304', 'sn_engine' => '1422A002066' ],
            [ 'no_lambung' => 'HT81016', 'site' => 'BSSR', 'model' => 'CMT 96', 'sn_unit' => 'CHSDH24HENC000405', 'model_engine' => 'WP12G290E304', 'sn_engine' => '1422K044570' ],
            [ 'no_lambung' => 'DT7399', 'site' => 'BSSR', 'model' => 'DFH3250A82', 'sn_unit' => 'KMTHD034T29015704', 'model_engine' => 'SAA6D170-5', 'sn_engine' => '611113 ( OVH PLR )' ],
            [ 'no_lambung' => 'MG333', 'site' => 'BSSR', 'model' => 'GR3005T', 'sn_unit' => 'KMTHD034C29015930', 'model_engine' => 'SAA6D170-5', 'sn_engine' => '15422' ],
            [ 'no_lambung' => 'LT023', 'site' => 'BSSR', 'model' => 'ACTROS-4043K', 'sn_unit' => 'KMTHD034K29015441', 'model_engine' => 'SAA6D170-5', 'sn_engine' => 'ZE-612050' ],
        ] );
    }
}
