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
    return view('welcome');
});

// Route pour afficher la page d'index des projets
Route::get('/project', [\App\Http\Controllers\ProjectController::class, 'index']);

// Route pour afficher la page de création d'un projet
Route::get('/project/create','App\Http\Controllers\ProjectController@create')->middleware("auth");

// Route pour stocker l'ajout ou modification
Route::post('/project', [\App\Http\Controllers\ProjectController::class, 'store']);

// Route pour afficher le projet sélectionné
Route::get('/project/{id}', [\App\Http\Controllers\ProjectController::class, 'show']);



// Route pour accéder à l'édition du projet sélectionné
Route::middleware(['auth:sanctum', 'verified'])->get('/project/{id}/edit', [\App\Http\Controllers\ProjectController::class, 'edit']);


// Route pour modifier le projet séléctionné
Route::middleware(['auth:sanctum', 'verified'])->put('/project/{id}', [\App\Http\Controllers\ProjectController::class, 'update']);

// Route pour supprimer le projet séléctionné
Route::middleware(['auth:sanctum', 'verified'])->delete('/project/{id}', [\App\Http\Controllers\ProjectController::class, 'destroy']);

//Route pour afficher la page de création d'un utilisateur
Route::middleware(['auth:sanctum', 'verified'])->get('/user/create','UserController@create');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('/dashboard');

// Route pour afficher la page de donnation
Route::middleware(['auth:sanctum', 'verified'])->get('/projectDonation/{id}', [\App\Http\Controllers\ProjectController::class, 'showDonation']);

// Route pour mettre à jour le total des dons
Route::middleware(['auth:sanctum', 'verified'])->post('/projectDonation/{id}', [\App\Http\Controllers\DonationController::class, 'store']);
