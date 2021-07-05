<?php

namespace Lidongyooo\Idempotent;

Trait IdempotentKeyGenerator
{

    public function generate()
    {
        $user = auth()->user();

        $idempotentKey = $user ? $user->getAuthIdentifier().\request() : \request()->ip().\request();

        $idempotentKey = md5($idempotentKey);

        \request()->headers->set(config('idempotent.header_name'), $idempotentKey);

        return $idempotentKey;
    }

}