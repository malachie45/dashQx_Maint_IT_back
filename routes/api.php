<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\EqpuipementController;
use App\Http\Controllers\api\apicontroller;
use App\Http\Controllers\EntreeController;
use App\Http\Controllers\TechnicienController;
use App\Http\Controllers\SortiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//recuperation de site pour les combo sites dans formulaire eqpt
Route::get('combsite', [EqpuipementController::class, 'getSites']);

//recuperation de site pour les combo sites dans formulaire Entrées
Route::get('combsiteentre', [EntreeController::class, 'getSitesEnt']);

//récupération d'équipements pour combo équipement dans entrees
Route::get('comboeqpt', [EntreeController::class, 'getEqpt']);

//recuperation des sorties par recherche sci ou coe site
Route::get('/recherche', [SortiController::class, 'rechercher']);

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
Route::post('/loginuser', [apicontroller::class, 'login']);

//statistiques
Route::get('/statistiques', [DashboardController::class, 'statistiques']);

// déconnexion
Route::middleware('auth:sanctum')->post('/logoutuser', [apicontroller::class, 'logout']);
