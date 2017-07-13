<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Tag;
use App\Observers\CategoryObserver;
use App\Observers\PostObserver;
use App\Observers\SettingObserver;
use App\Observers\TagObserver;
use App\Repositories\Contracts\SettingRepository;
use App\Services\CacheHelper;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'posts' => \App\Models\Post::class
        ]);

        Post::observe(PostObserver::class);
        Tag::observe(TagObserver::class);
        Category::observe(CategoryObserver::class);
        Setting::observe(SettingObserver::class);

        $this->app->singleton('settings', function (Container $app) {
            return $app['cache']->rememberForever(CacheHelper::keySiteSettings(), function () use ($app) {
                return $app->make(SettingRepository::class)->siteSettings();
            });
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() != 'production' ) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
