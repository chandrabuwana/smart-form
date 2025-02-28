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
     public function dashboard(){
        return view('smartform::production.form_checker.dashboard-form-checker');
     }

}
