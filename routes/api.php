<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\EqpuipementController;
use App\Http\Controllers\api\apicontroller;
use App\Http\Controllers\EntreeController;
use App\Http\Controllers\TechnicienController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//recuperation de site pour les combo sites dans formulaire eqpt
Route::get('combsite', [EqpuipementController::class, 'getSites']);

//recuperation de site pour les combo sites dans formulaire Entrées
Route::get('combsiteentre', [EntreeController::class, 'getSitesEnt']);

//récupération d'équipements pour combo équipement dans entrees
Route::get('comboeqpt', [EntreeController::class, 'getEqpt']);

//les insertion de data
Route::post('/insite', [SiteController::class, 'store']);
Route::post('/ineqpt', [EqpuipementController::class, 'store']);
// Route::middleware('auth:sanctum')->post('/inentrees', [EntreeController::class, 'store']);
Route::post('/inentrees', [EntreeController::class, 'store']);
// Route::middleware('auth:sanctum')->post('/inentrees', [EntreeController::class, 'store']);
Route::post('/intech', [TechnicienController::class, 'store']);
//route de recherche des entrées à faire sortir
Route::get('/recherche-entree', [EntreeController::class, 'recherche']);

//creation de profil
Route::post('/register', [apicontroller::class, 'register']);

//connexion par profile
Route::post('/login', [apicontroller::class, 'login']);

// déconnexion
Route::middleware('auth:sanctum')->post('/logout', [apicontroller::class, 'logout']);
