<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AseetController;
use App\Http\Controllers\EmployeeController;
use \App\Http\Controllers\AuthController;

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



Route::post('/employeeInsert', [EmployeeController::class, 'employeeInsert']);

Route::put('/employeeUpdate/{id}', [EmployeeController::class, 'employeeUpdate']);

Route::delete('/employeeDelete/{id}', [EmployeeController::class, 'employeeDelete']);

Route::get('/employeeList', [EmployeeController::class, 'employeeList']);

Route::post('/employeeSearchWithName', [EmployeeController::class, 'employeeSearchWithName']);

Route::post('/employeeSearchWithId', [EmployeeController::class, 'employeeSearchWithId']);



Route::middleware("auth:sanctum")->get('employeeInfo', [EmployeeController::class, 'employeeInfo']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
