<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UserAttributes;
use Carbon\Carbon;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string[] ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guest()) {
            throw new AuthenticationException('Unauthenticated');
        }
        /**
         * @var $attributes UserAttributes
         * @var $user User
         */
        $user = Auth::user();
        $attributes = $user->attributes ?: new UserAttributes;
        $attributes->last_seen_at = Carbon::now();
        $user->attributes()->save($attributes);


        return $next($request);

    }
}
