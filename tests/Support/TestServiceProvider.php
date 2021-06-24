<?php

namespace Lidongyooo\Idempotent\Tests\Support;

class TestServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }
}