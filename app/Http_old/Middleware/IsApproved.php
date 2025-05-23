<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsApproved
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
        $isApproved = Auth::user()->isapproved;
        if($isApproved <> 'Y')
        {
            return redirect('/verifyuser');
        }
        return $next($request);
    }
}
