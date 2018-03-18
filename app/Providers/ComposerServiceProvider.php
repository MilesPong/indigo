<?php

namespace App\Providers;

use App\Http\ViewComposers\CategoriesComposer;
use App\Http\ViewComposers\CommentComposer;
use App\Http\ViewComposers\GoogleAnalyticsComposer;
use App\Http\ViewComposers\HotPostsComposer;
use App\Http\ViewComposers\TagsComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Class ComposerServiceProvider
 * @package App\Providers
 */
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['widgets.category', 'partials.navbar', 'partials.sidenav'], CategoriesComposer::class);
        View::composer('widgets.tag', TagsComposer::class);
        View::composer('widgets.hot', HotPostsComposer::class);
        View::composer('partials.comment', CommentComposer::class);
        View::composer('partials.google_analytics', GoogleAnalyticsComposer::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // In this case, I just simply register the CategoriesComposer to singleton to avoid duplicate
        // DB queries while rendering multiple views in the same time. Another ways like using cache,
        // shared data are might be better solutions.
        $this->app->singleton(CategoriesComposer::class);
    }
}