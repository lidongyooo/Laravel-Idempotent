<?php

namespace Lidongyooo\Idempotent\Tests;

class IdempotentMiddlewareTest extends TestCase
{
    public function testGetPassable()
    {
        $response = $this->get('tests');
        $response->assertSeeText('index');
    }

    public function testNotContainKeyPassable()
    {
        $response = $this->post('tests');
        $response->assertSeeText('store');
    }

    public function testForcible()
    {
        $this->app['config']->set('idempotent.forcible', true);

        $response = $this->post('tests');
        $response->assertSeeText('store');

        $response = $this->post('tests');
        $response->assertHeader(config('idempotent.back_header_name'));
    }

    public function testRepeated()
    {
        $headers = [
            config('idempotent.header_name') => md5('idempotent')
        ];

        //I can't test in parallel……
        $this->post('tests', [], $headers);
        $response = $this->post('tests', [], $headers);
        $response->assertStatus(425);
    }

    public function testGenerateKey()
    {
        $response = $this->post('idempotent');
        $idempotentKey1 = $response->getContent();

        $response = $this->post('idempotent');
        $idempotentKey2 = $response->getContent();

        $this->assertTrue($idempotentKey1 === $idempotentKey2);
    }
}