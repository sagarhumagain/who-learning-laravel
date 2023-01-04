<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasProfileMiddleware
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
        if (auth()->user()->is_first_time_login) {
            $data['error'] = true;
            $data['message'] = 'Please complete your profile first and wait for the admin approval';
            return response()->json($data, 401);
        }
        return $next($request);
    }
}
