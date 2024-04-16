<?php

use App\Http\Controllers\PostController;
use App\Mail\OrderShipped;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

// RETRIEVING DATA FROM SESSION
    Route::get('get-session', function(Request $request){
        $data = session()->all();

        // $data = $request->session()->all();

        // $data = $request->session()->get('_token');
        dd($data);
    });

// STORING DATA AT SESSION 
    Route::get('save-session', function(Request $request){
    //1ST WAY TO STORE DATA    
        $request->session()->put('user_id', '123');//specify key and value in put method

    //2ND WAY TO STORE DATA
        $request->session()->put([
            'user_status' => 'logged_in',
            'name' => 'ren'
        ]);

    //3RD WAY TO STORE DATA
            session([
                'user_ip' => '123.23.11',
            ]);
        return redirect('get-session');
    });

//DELETING DATA FROM SESSION
    Route::get('destroy-session', function(Request $request){
    //1ST WAY TO DELETE DATA    
        // $request->session()->forget('user_id');

    //2ND WAY TO DELETE DATA
        // $request->session()->forget([
        //     'user_id',
        //     'name',
        //     'user_ip'
        // ]);

    //3RD WAY TO DELETE DATA
        // session()->forget([
        //     'user_id',
        //     'name',
        //     'user_ip'
        // ]);
    
    //4TH WAY TO DELETING ALL OF DATA FROM SESSION
        // session()->flush();//this way or
        $request->session()->flush();//this way
        return redirect('get-session');
    });

// FLASH SESSION DATA
    Route::get('flash-session', function(Request $request){
        $request->session()->flash('status', 'true');
        return redirect('get-session');
    });

// REMOVING DATA FROM CACHE
    Route::get('forget-cache', function(){
        Cache::forget('posts');
    });