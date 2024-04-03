<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts/trash', [PostController::class, 'trashed'])->name('posts.trashed');
route::get('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
route::delete('/posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.force_delete');
Route::resource('posts', PostController::class);