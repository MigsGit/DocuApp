<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class CustomMiddleware extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function handle($request,Closure $next)
    {
        Log::debug("message");
        Log::debug($request); //debug and log will found in storage laravel.log

        $check_browser = $request->header('user-agent');
        if( str_contains($check_browser,'Google'))
        {
            return route('login'); //web.php unauthenticated go back to login
        }
        return $next($request);
    }
}
