<?php

namespace Modules\DokumenMutu\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DokumenMutuController extends Controller
{
    public function index()
    {
        return view('DokumenMutu::index');
    }
}
