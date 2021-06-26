<?php

namespace Lidongyooo\Idempotent;

Class IdempotentServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/idempotent.php', 'idempotent');
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->app['router']->aliasMiddleware('idempotent', IdempotentMiddleware::class);
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/idempotent.php' => config_path('idempotent.php')
            ], 'idempotent');
        }
    }

}