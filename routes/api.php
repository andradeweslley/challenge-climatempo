<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('heartbeat', function () {
        return response()->json(['status' => 'OK', 'message' => 'Heart is beating']);
    });

    Route::apiResources([
        'locales' => LocaleController::class,
        'weather' => WeatherController::class,
    ]);
});
