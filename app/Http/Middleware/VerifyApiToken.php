<?php

namespace App\Http\Middleware;

use App\Support\Api;
use Closure;

class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $this->tokensMatch($request)) {
            return api('Forbidden request', 403);
        }

        $request->attributes->set('current_app_key', $this->getAppKey($request));

        return $next($request);
    }

    protected function tokensMatch($request)
    {
        if ($time = $this->getTime($request)) {
            return (abs(time() - (int) $time) < (int) config('api.token_duration')) &&
                Api::verifyToken($this->getToken($request), $this->getAppKey($request), $time);
        }
    }

    protected function getAppKey($request)
    {
        return $request->input('_key') ?: $request->header('X-API-KEY');
    }

    protected function getTime($request)
    {
        return $request->input('_time') ?: $request->header('X-API-TIME');
    }

    protected function getToken($request)
    {
        return $request->input('_token') ?: $request->header('X-API-TOKEN');
    }
}
