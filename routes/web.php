<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.app');
});
Route::resource('posts', PostController::class);
Route::middleware('auth:sanctum')->resource('categories', CategoryController::class);
Route::resource('comments', CommentController::class);
Route::patch('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
Route::patch('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
