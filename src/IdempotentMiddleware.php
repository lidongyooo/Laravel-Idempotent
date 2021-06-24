<?php

namespace Lidongyooo\Idempotent;

use Illuminate\Http\Request;

class IdempotentMiddleware
{
    public function handler(Request $request, \Closure $next)
    {
        return $next($request);
    }
}