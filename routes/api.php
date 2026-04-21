<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\DashboardController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']); 
Route::put('/products/{id}', [ProductController::class, 'update']); 
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::get('/dashboard', [DashboardController::class, 'index']);