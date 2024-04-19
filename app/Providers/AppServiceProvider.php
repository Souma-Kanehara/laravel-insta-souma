<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        paginator::useBootstrap();

        Gate::define('admin',function($user){ // 'admin'はweb.phpからきてる
            /**
             * $user is array --> $user['role_id' => 1, 'email' => 'john.smith@gmail.com', 'password' => 'fgnjahgrah hrw[grgh...']
             */
            return $user->role_id === User::ADMIN_ROLE_ID;
        });
    }
}
