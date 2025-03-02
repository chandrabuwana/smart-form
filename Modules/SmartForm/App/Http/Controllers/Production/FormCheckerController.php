<?php

namespace Modules\SmartForm\App\Http\Controllers\Production;

use App\Helper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class FormCheckerController extends Controller {
    public function dashboard() {
        return view( 'smartform::production.form_checker.dashboard-form-checker' );
    }

    public function AddFormChecker() {
        $dataDS = [
            '06-00 sd 07.00',
            '07-00 sd 08.00',
            '08-00 sd 09.00',
            '09-00 sd 10.00',
            '10-00 sd 11.00',
            '11-00 sd 12.00',
            '12-00 sd 13.00',
            '13-00 sd 14.00',
            '14-00 sd 15.00',
            '15-00 sd 16.00',
            '16-00 sd 17.00',
            '17-00 sd 18.00',
        ];
        $dataNS = [
            '18-00 sd 19.00',
            '19-00 sd 20.00',
            '20-00 sd 21.00',
            '21-00 sd 22.00',
            '22-00 sd 23.00',
            '23-00 sd 00.00',
            '00-00 sd 01.00',
            '01-00 sd 02.00',
            '02-00 sd 03.00',
            '03-00 sd 04.00',
            '04-00 sd 05.00',
            '05-00 sd 06.00',
        ];

        return view( 'smartform::production.form_checker.form-checker', compact( 'dataDS', 'dataNS' ) );
    }

    public function StoreChecker( Request $request ) {
        dd($request->all());
       

    }
}
