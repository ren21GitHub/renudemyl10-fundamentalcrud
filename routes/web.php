<?php

use App\Http\Controllers\PostController;
use App\Mail\OrderShipped;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'authCheck'], function(){
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
    Route::get('/profile', function(){
        return view('profile');
    });
});

Route::get('/posts/trash', [PostController::class, 'trashed'])->name('posts.trashed');
route::get('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
route::delete('/posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.force_delete');

// Route::resource('posts', PostController::class)->middleware('authCheck');
Route::resource('posts', PostController::class);

Route::get('/unavailable', function(){
    return view('unavailable');
})->name('unavailable');

//Route::group([], callback)

Route::get('/contact', function () {
    $posts = Post::all();
    return view('contact', compact('posts'));
});

Route::get('send-mail', function(){
//SEND A SIMPLE EMAIL WITH LARAVEL
    // Mail::raw('Hello world test mail', function($message){
    //     $message->to('test@gmail.com')->subject('noreply');
    // });

//SEND HTML VIEW AS AN EMAIL BODY
    Mail::send(new OrderShipped);

    dd('success!!');
});