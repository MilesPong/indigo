<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $bindings = [
        \App\Repositories\Contracts\PermissionRepository::class => \App\Repositories\Eloquent\PermissionRepositoryEloquent::class,
        \App\Repositories\Contracts\RoleRepository::class => \App\Repositories\Eloquent\RoleRepositoryEloquent::class,
        \App\Repositories\Contracts\UserRepository::class => \App\Repositories\Eloquent\UserRepositoryEloquent::class,
        \App\Repositories\Contracts\CategoryRepository::class => \App\Repositories\Eloquent\CategoryRepositoryEloquent::class,
        \App\Repositories\Contracts\TagRepository::class => \App\Repositories\Eloquent\TagRepositoryEloquent::class,
        \App\Repositories\Contracts\PostRepository::class => \App\Repositories\Eloquent\PostRepositoryEloquent::class,
        \App\Repositories\Contracts\VisitorRepository::class => \App\Repositories\Eloquent\VisitorRepositoryEloquent::class,
        \App\Repositories\Contracts\SettingRepository::class => \App\Repositories\Eloquent\SettingRepositoryEloquent::class,
        \App\Repositories\Contracts\PageRepository::class => \App\Repositories\Eloquent\PageRepositoryEloquent::class,
    ];

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
        foreach ($this->bindings() as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /**
     * @return array
     */
    public function bindings()
    {
        return $this->bindings;
    }
}
