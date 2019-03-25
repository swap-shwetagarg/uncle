<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AuthisAdmin {

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
        if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Master')) {
            return $next($request);
        }
        return redirect()->back();
    }

}
