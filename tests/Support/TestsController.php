<?php

namespace Lidongyooo\Idempotent\Tests\Support;

class TestsController extends \Illuminate\Routing\Controller
{
    public function index()
    {
        return 'index';
    }

    public function store()
    {
        return 'store';
    }
}