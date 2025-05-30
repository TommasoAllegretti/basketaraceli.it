<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('pages/welcome');
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

require __DIR__.'/auth.php';
