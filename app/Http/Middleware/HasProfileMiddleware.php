<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

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
        }else if (!isEmpty(auth()->user()->contracts) && auth()->user()->contracts->last()->contract_end < Carbon::now() && auth()->user()->hasRole('normal-user') ){
            $data['error'] = true;
            $data['message'] = 'Your contract has expired';
            return response()->json($data, 401);
        }
        return $next($request);
    }
}
