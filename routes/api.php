<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\EqpuipementController;
use App\Http\Controllers\api\apicontroller;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//irecuperation de site pour les combo sites
Route::get('combsite', [EqpuipementController::class, 'getSites']);

//les insertion de data
Route::post('/insite', [SiteController::class, 'store']);
Route::post('/ineqpt', [EqpuipementController::class, 'store']);

//creation de profil
Route::post('/register', [apicontroller::class, 'register']);

//connexion par profile
Route::post('/login', [apicontroller::class, 'login']);

// déconnexion
Route::middleware('auth:sanctum')->post('/logout', [apicontroller::class, 'logout']);
