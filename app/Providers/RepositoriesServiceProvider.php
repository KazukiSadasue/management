<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \App::bind('App\Repositories\UserRepositoryInterface', 'App\Repositories\UserRepository');
        \App::bind('App\Repositories\AdminRepositoryInterface', 'App\Repositories\AdminRepository');
        \App::bind('App\Repositories\HistoryRepositoryInterface', 'App\Repositories\HistoryRepository');
        \App::bind('App\Repositories\WorkScheduleRepositoryInterface', 'App\Repositories\WorkScheduleRepository');
    }
}
