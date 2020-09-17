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

// Route pour afficher le projet sélectionné
Route::get('/project/{id}', [\App\Http\Controllers\ProjectController::class, 'show']);

//Route pour afficher la page de création d'un utilisateur
Route::get('/user/create','UserController@create');

