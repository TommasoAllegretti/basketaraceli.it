<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\LeagueController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\StatController;
use App\Http\Controllers\Api\GameStatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // Player routes
    Route::apiResource('players', PlayerController::class);
    
    // Team routes
    Route::apiResource('teams', TeamController::class);
    
    // League routes
    Route::apiResource('leagues', LeagueController::class);

    // Game routes
    Route::apiResource('games', GameController::class);

    // Stat routes
    Route::apiResource('stats', StatController::class);

    // Game stat routes
    Route::apiResource('game-stats', GameStatController::class);
});

// Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
