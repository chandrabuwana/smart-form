<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    function DashboardIndex(){
        // dd("asdad");
        return view("master/master_page");
    }

}
