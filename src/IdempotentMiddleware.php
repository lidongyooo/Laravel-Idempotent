<?php

namespace Lidongyooo\Idempotent;

use Illuminate\Http\Request;

class IdempotentMiddleware
{
    //Request Method
    protected $method;

    protected $config;

    public function handle(Request $request, \Closure $next, $save = false)
    {
        $this->method = $request->getMethod();
        $this->config = config('idempotent');

        if (!isset($this->config['methods'][$this->method])) {
            return $next($request);
        }

        $idempotentKey = $this->getIdempotentKey();
        if (!$idempotentKey) {
            return $next($request);
        }

        return $next($request);
    }

    protected function getIdempotentKey()
    {
        return $this->config['forcible'] ? $this->generateIdempotentKey() : \request()->header($this->config['header_name']);
    }

    protected function generateIdempotentKey()
    {
        $user = auth()->user();

        $idempotentKey = $user ? $user->getAuthIdentifier().\request() : \request()->ip().\request();

        return md5($idempotentKey);
    }

    protected function save($save)
    {
        return $save ? true : $this->config['methods'][$this->method]['save'];
    }
}