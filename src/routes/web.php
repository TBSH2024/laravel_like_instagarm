<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 投稿
    Route::get('/post/create', [PostController::class, 'create']);
    Route::post('/post/create', [PostController::class, 'store'])
    ->name('post.store');
    Route::get('/post/edit/{post}', [PostController::class, 'edit'])
    ->name('post.edit');
    Route::patch('/post/update/{post}', [PostController::class, 'update'])
    ->name('post.update');
    Route::post('/post/delete/{post}', [PostController::class, 'destroy'])
    ->name('post.delete');
    Route::post('/post/images/{post}', [PostController::class, 'storeImage'])
    ->name('post.images.store');
});

Route::get('login/github', [ SocialLoginController::class, 'redirectToGithub'])
->name('login.github');
Route::get('login/github/callback', [ SocialLoginController::class, 'handleGithubCallback']);

Route::get('/posts', [PostController::class, 'index'])
->name('posts.index');
Route::get('/post/{post}', [PostController::class, 'show'])
->name('post.show');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])
    ->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout']);

    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });
});

Route::get('/list-data', function () {
    return session()->all();
});

require __DIR__.'/auth.php';
