<?php

namespace App\Http\Controllers\SHE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardSHEFRM19BController extends Controller
{
    //


    function DashboardIndex(){
        return view('she/fatig/dashboard-she-019b-pekerja');
    }

    function AddForm(){
        return view('she/fatig/add-form-she-019b-pekerja');
    }
}
