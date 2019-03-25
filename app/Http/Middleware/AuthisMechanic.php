<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AuthisMechanic {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::user()->hasRole('Mechanic')) {
            return $next($request);
        }
        return redirect()->back();
    }

}
