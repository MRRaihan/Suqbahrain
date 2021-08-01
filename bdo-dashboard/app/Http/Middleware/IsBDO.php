<?php

namespace App\Http\Middleware;

use Closure;
/*use Auth;*/
use Illuminate\Support\Facades\Auth;

class IsBDO
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
        if (Auth::check() && Auth::user()->user_type == 'bdo' && Auth::user()->status == 1) {
            return $next($request);
        }
        else{
            return redirect()->route('bdo.login');
        }
    }
}
