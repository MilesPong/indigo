<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\Contracts\PermissionRepository::class,
            \App\Repositories\Eloquent\PermissionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\RoleRepository::class,
            \App\Repositories\Eloquent\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\UserRepository::class,
            \App\Repositories\Eloquent\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\CategoryRepository::class,
            \App\Repositories\Eloquent\CategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\TagRepository::class,
            \App\Repositories\Eloquent\TagRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\PostRepository::class,
            \App\Repositories\Eloquent\PostRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\VisitorRepository::class,
            \App\Repositories\Eloquent\VisitorRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\SettingRepository::class,
            \App\Repositories\Eloquent\SettingRepositoryEloquent::class);
    }
}
