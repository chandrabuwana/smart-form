<?php

namespace Modules\SmartForm\App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    function DashboardIndex(){
        return view("SmartForm::master/master_page");
    }

}
