<?php

namespace Lidongyooo\Idempotent;

class IdempotentController extends \Illuminate\Routing\Controller
{
    public function store()
    {
        return IdempotentKeyGenerator::generate();
    }
}