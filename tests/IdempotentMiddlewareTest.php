<?php

namespace Lidongyooo\Idempotent\Tests;

class IdempotentMiddlewareTest extends TestCase
{
    public function testToken()
    {
        $response = $this->post('token');
        $response->assertStatus(200);
    }
}