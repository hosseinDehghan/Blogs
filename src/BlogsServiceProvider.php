<?php

namespace Hosein\Blogs;

use Illuminate\Support\ServiceProvider;

class BlogsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/Views', 'BlogsView');
        $this->publishes([
            __DIR__.'/Views' => resource_path('views/vendor/BlogsView'),
        ],"blogsview");
        $this->publishes([
            __DIR__.'/Migrations' => database_path('/migrations')
        ], 'migrations');
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
    }
}
