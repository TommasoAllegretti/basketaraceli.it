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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('leagues', LeagueController::class)->middleware(['auth', 'verified', 'admin']);
Route::resource('teams', TeamController::class)->middleware(['auth', 'verified', 'admin']);
Route::resource('players', PlayerController::class)->middleware(['auth', 'verified', 'admin']);
Route::resource('games', GameController::class)->middleware(['auth', 'verified', 'admin']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/my-player', [PlayerController::class, 'show'])->name('player.show');
});

require __DIR__ . '/auth.php';
