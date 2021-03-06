<?php

namespace App\Http\Middleware;

use Closure;
use Vinkla\Hashids\Facades\Hashids;

class InitAppConfig
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
        // intval(request()->get('appid')))
        ( new \App\Repositories\AppRepository )->initConfig();

        return $next($request);
    }
}
    