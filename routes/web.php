<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::prefix('blog')->group(function () {
    Route::get('post', [PostController::class, 'index'])->name('post.index');
    Route::get('post/{post:slug}', [PostController::class, 'show'])->name('post.show');
});
