<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

use SleepingOwl\Admin\Contracts\ModelConfigurationInterface;
use App\Admin\Sections\Posts;
use App\Models\Post;

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
         $this->app->bind(ModelConfigurationInterface::class, function ($app) {
            return new Posts($app, Post::class);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('de');
        Paginator::defaultView('vendor.pagination.bootstrap-4');
    }
}
