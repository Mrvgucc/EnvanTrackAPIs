<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AseetController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);


Route::post('/categoryInsert', [CategoryController::class, 'categoryInsert']);

Route::put('/categoryUpdate/{id}', [CategoryController::class, 'categoryUpdate']);

Route::delete('/categoryDelete/{id}', [CategoryController::class, 'categoryDelete']);

Route::get('/categoryList', [CategoryController::class, 'categoryList']);


Route::post('/assetInsert', [AseetController::class, 'assetInsert']);

Route::put('/assetUpdate/{id}', [AseetController::class, 'assetUpdate']);

Route::delete('/assetDelete/{id}', [AseetController::class, 'assetDelete']);

Route::get('/assetList', [AseetController::class, 'assetList']);
