<?php

namespace Modules\SmartForm\App\Http\Controllers\SHE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardSHEFRM19BController extends Controller
{
    //


    function DashboardIndex(){
        return view('SmartForm::she/fatig/dashboard-she-019b-pekerja');
    }

    function AddForm(){
        return view('SmartForm::she/fatig/add-form-she-019b-pekerja');
    }
}
