<?php

namespace App\Http\Middleware;

use Closure;

class UrlAuthorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $value
     * @param  string  $key
     * @return mixed
     */
    public function handle($request, Closure $next, $value = null, $key = null)
    {
        $key = ! is_null($key) ? $key : config('var.url_auth.key');
        $value = ! is_null($value) ? $value : config('var.url_auth.value');

        if ($request->input($key) !== $value) {
            return abort(403);
        }

        return $next($request);
    }
}
