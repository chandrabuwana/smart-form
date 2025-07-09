<?php

namespace Modules\SmartForm\App\Http\Controllers\LOG;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\SmartForm\helpers\HrdHelper;

class LogController extends Controller {


    private const TABLE_MASTER = 'FM_LOG_002_REQUESTER_MASTER';
    private const TABLE_DETAIL = 'FM_LOG_002_REQUESTER_MASTER_DETAIL';

    public function download() {
        $pdf = Pdf::loadView('pdf');
 
        return $pdf->download();
    }

}
