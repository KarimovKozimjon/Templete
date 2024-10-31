<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;

Route::get('/', function () {
    return view('welcome');
})->name("home");

Route::get("/register", [AuthController::class, "registerForm"])->name("registerForm");

