<?php

use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/search/{type}', [SearchController::class, 'index']);
Route::get('/details/{type}/{id}', [DetailsController::class, 'index']);
Route::get('/statistics', [StatisticsController::class, 'index']);