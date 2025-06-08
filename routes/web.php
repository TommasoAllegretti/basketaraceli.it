<?php

use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

// Public routes
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

// CRM routes - all authenticated routes under /crm prefix
Route::prefix('crm')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/{any?}', function () {
        return view('vue');
    })->where('any', '.*');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
