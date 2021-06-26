<?php

namespace Lidongyooo\Idempotent;

class IdempotentKeyGenerator
{

    public static function generate()
    {
        $user = auth()->user();

        $idempotentKey = $user ? $user->getAuthIdentifier().\request() : \request()->ip().\request();

        return md5($idempotentKey);
    }

}