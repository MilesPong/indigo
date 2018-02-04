<?php

namespace App\Providers;

use App\Indigo\Tools\Counter;
use Barryvdh\Debugbar\ServiceProvider;

/**
 * Class CounterServiceProvider
 * @package App\Providers
 */
class CounterServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot()
    {
    }

    /**
     *
     */
    public function register()
    {
        $this->app->singleton(\App\Indigo\Contracts\Counter::class, function ($app) {
            $config = $this->getConfig();
            return new Counter($app, $config['cache_store']);
        });
    }

    /**
     * @return mixed
     */
    protected function getConfig()
    {
        return $this->app['config']['indigo.counter'];
    }
}