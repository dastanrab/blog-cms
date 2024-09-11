<?php

use App\Http\Controllers\API\auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register'])->name('api.register');
Route::post('login', [AuthController::class, 'login'])->name('api.login');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');
Route::middleware('auth:sanctum')->apiResource('post',\App\Http\Controllers\API\post\PostController::class);
