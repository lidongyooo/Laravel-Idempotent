<?php

namespace Lidongyooo\Idempotent;

use Illuminate\Http\Request;

class IdempotentMiddleware
{
    use IdempotentKeyGenerator;

    protected $method;

    protected $config;

    protected $save;

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
        $this->setSave($save);
        return $next($request);
    }

    public function terminate($request, $response)
    {
        if (is_null($this->save)) {
            return;
        }

        if ($this->save && !$response->exception) {
            \Cache::put($this->getCacheKey($request->header($this->config['header_name'])), $response, $this->config['methods'][$this->method]['save_ttl']);
        } else {
            \Cache::forget($this->getCacheKey($request->header($this->config['header_name'])));
        }
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
        return $this->config['forcible'] ? $this->generate() : \request()->header($this->config['header_name']);
    }

    protected function setSave($save)
    {
        $this->save = $save ? true : $this->config['methods'][$this->method]['save'];
    }
}