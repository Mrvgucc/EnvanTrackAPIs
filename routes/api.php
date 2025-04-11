<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);


Route::post('/categoryInsert', [CategoryController::class, 'categoryInsert']);

Route::put('/categoryUpdate/{id}', [CategoryController::class, 'categoryUpdate']);

Route::delete('/categoryDelete/{id}', [CategoryController::class, 'categoryDelete']);

Route::get('/categoryList', [CategoryController::class, 'categoryList']);
