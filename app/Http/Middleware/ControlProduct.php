<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ControlProduct
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if($request->header('key') != 'abcdefg'){
            return response()->json('you mission header key');
        }

        return $next($request);

    }
}
