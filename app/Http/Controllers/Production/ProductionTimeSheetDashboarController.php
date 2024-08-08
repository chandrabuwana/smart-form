<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductionTimeSheetDashboarController extends Controller
{
    //

    function IndexDashboard(){
        return view("production/timesheet/add-form-timesheet-prod");
    }
}
