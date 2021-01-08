<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        $accessToken = $request->headers->get('AuthorizationBearer');
        if ($accessToken) {
            $request->headers->set('Authorization', $accessToken, true);
            $request->headers->remove('AuthorizationBearer');
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }
}
