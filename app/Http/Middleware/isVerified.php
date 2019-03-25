<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class isVerified
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
         if(Auth::check() && Auth::user()->verified) {
            return $next($request);
        }
            return redirect('/');
    }
}
