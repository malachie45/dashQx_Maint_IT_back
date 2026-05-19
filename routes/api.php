<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\EqpuipementController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//irecuperation de site pour les combo sites
Route::get('combsite', [EqpuipementController::class, 'getSites']);

//les insertion de data
Route::post('/insite', [SiteController::class, 'store']);
Route::post('/ineqpt', [EqpuipementController::class, 'store']);


