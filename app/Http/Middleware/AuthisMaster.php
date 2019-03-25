<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AuthisMaster {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if( Session::has( 'orig_user' ) ) {
            return redirect()->intended('/');
        }
        if (Auth::user()->hasRole('Master')) {
            return $next($request);
        }
        return redirect()->back();
    }

}

