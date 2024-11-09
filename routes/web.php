<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\NotificationController;

Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');
Route::get('/', function () {
    return view('welcome');
})->name("home");

Route::get("/register", [AuthController::class, "registerForm"])->name("registerForm");
Route::post("/register", [AuthController::class, "register"])->name("register");

Route::get("/login", [AuthController::class, "loginForm"])->name("loginForm");
Route::post("/login", [AuthController::class, "login"])->name("login");

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [PostController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/logout', [ProfileController::class, 'logout'])->name('logout');

    Route::get('/create', [PostController::class, 'createPostForm'])->name('createPostForm');
    Route::post('/create', [PostController::class, 'createPost'])->name('createPost');

    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

    // Tahrirlash uchun yo'nalishlar
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/user/{id}', [UserProfileController::class, 'show'])->name('user.profile');

    Route::post('/user/{user}/follow', [UserProfileController::class, 'follow'])->name('user.follow');
    Route::post('/user/{user}/unfollow', [UserProfileController::class, 'unfollow'])->name('user.unfollow');
});
