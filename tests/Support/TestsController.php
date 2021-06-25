<?php

namespace Lidongyooo\Idempotent\Tests\Support;

class TestsController extends \Illuminate\Routing\Controller
{
    public function store()
    {
        return 'come in';
    }
}