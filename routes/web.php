<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [PostController::class, 'index'])->name('home');

Route::resource('posts', PostController::class)->only(['index']);

Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class)->except(['index']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth'])->name('dashboard');


require __DIR__ . '/auth.php';
