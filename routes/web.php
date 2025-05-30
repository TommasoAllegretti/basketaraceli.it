<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('pages/home');
});

Route::get('/eventi', function () {
    return view('pages/eventi');
});

Route::get('/squadre', function () {
    return view('pages/squadre');
});

Route::get('/organizzazione', function () {
    return view('pages/organizzazione');
});

Route::get('/contatti', function () {
    return view('pages/contatti');
});

require __DIR__ . '/auth.php';
