<?php

namespace Lidongyooo\Idempotent\Tests;

use Lidongyooo\Idempotent\IdempotentServiceProvider;
use Lidongyooo\Idempotent\Tests\Support\TestServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{

    public function getPackageProviders($app)
    {
        return [
            IdempotentServiceProvider::class,
            TestServiceProvider::class
        ];
    }


}