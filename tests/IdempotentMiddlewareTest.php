<?php

namespace Lidongyooo\Idempotent\Tests;

class IdempotentMiddlewareTest extends TestCase
{
    public function testHandle()
    {
        $response = $this->post('tests');
    }
}