<?php

use App\Http\Middleware\FetchMenu;
use Illuminate\Support\Facades\Route;
use Modules\DokumenMutu\App\Http\Controllers\DokumenMutuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware([ FetchMenu::class ])->group( function() {
    Route::get('/dokumen-mutu', [DokumenMutuController::class, 'index']);
});
