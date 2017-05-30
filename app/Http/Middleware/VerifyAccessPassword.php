<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAccessPassword
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
        if ($request->input('access_password') !== config('var.access_password')) {
            return response('密码错误', 403);
        }

        return $next($request);
    }
}
