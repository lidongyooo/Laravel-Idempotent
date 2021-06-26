<?php

namespace Lidongyooo\Idempotent;

use Illuminate\Http\Request;

class IdempotentMiddleware
{
    protected $method;

    protected $config;

    const PLACE_HOLDER = 'idempotent_place_holder';

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

        if ($response = $this->repeated($idempotentKey)) {
            $response->header($this->config['back_header_name'], $idempotentKey);
            return $response;
        }

        \Cache::put($this->getCacheKey($idempotentKey), self::PLACE_HOLDER);

        $response = $next($request);

        if ($this->save($save)) {
            \Cache::put($this->getCacheKey($idempotentKey), $response, $this->config['methods'][$this->method]['save_ttl']);
        } else {
            \Cache::forget($this->getCacheKey($idempotentKey));
        }

        return $response;
    }

    protected function repeated($idempotentKey)
    {
        if ($value = \Cache::get($this->getCacheKey($idempotentKey))) {
            if ($value === self::PLACE_HOLDER) {
                abort(425, 'Your request is still being processed.');
            }

            return $value;
        }

        return false;
    }

    protected function getCacheKey($idempotentKey)
    {
        return 'idempotent_key:'.$idempotentKey;
    }

    protected function getIdempotentKey()
    {
        return $this->config['forcible'] ? IdempotentKeyGenerator::generate() : \request()->header($this->config['header_name']);
    }

    protected function save($save)
    {
        return $save ? true : $this->config['methods'][$this->method]['save'];
    }
}