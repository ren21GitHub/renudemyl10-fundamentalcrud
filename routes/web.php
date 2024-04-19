<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Jobs\SendMail;
use App\Mail\PostPublished;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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

require __DIR__.'/auth.php';

//PROTECTING ROUTES
    Route::group(['middleware' => 'auth'], function(){

        // CRUD ROUTES
            Route::get('/posts/trash', [PostController::class, 'trashed'])->name('posts.trashed');
            Route::get('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
            Route::delete('/posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.force_delete');

            Route::resource('/posts', PostController::class);

        //  RETRIEVING THE AUTHENTICATED USER
            Route::get('user-data', function(){
                // return Auth::user();
                // return Auth::user()->email;
                // return auth()->user();
                return auth()->user()->name;
            });

    });


// QUEUEING AN EMAIL

    Route::get('send-email', function(){
        // Mail::send(new PostPublished());

        // QUEUEING AN EMAIL
            SendMail::dispatch();
            dd('Queueing Email successfully!');
    });

