<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('hasCurrentRoute', function (...$routes) {
            return array_search(Route::currentRouteName(), $routes) !== false;
        });
        Blade::if('isCurrentRoute', function ($route) {
            return Route::currentRouteName() == str_replace('\"', '', $route);
        });
        Blade::if('hasRole', function (...$roles) {
            $userRole = Auth::user()->role ?? null;
            return array_search($userRole, $roles) !== false;
        });

        Paginator::defaultView('vendor.pagination.default');
    }
}
