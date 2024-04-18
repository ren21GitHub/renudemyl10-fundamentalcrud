<?php

namespace App\Providers;

use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        //SHARE DATA IN BLADE FILES
            View::share('site_name', 'MY SITE');


        // AUTHORIZATION GATES

            //  1. create_post
            //  2. edit_post
            //  3. delete_post

            // Gate::define('create_post', function(){
            //     return Auth::user()->is_admin;
            // });;

            // Gate::define('edit_post', function(){
            //     return Auth::user()->is_admin;
            // });

            // Gate::define('delete_post', function(){
            //     return Auth::user()->is_admin;
            // });

        // AUTHORIZATION POLICY

            Gate::policy(Post::class, PostPolicy::class);
    }
}
