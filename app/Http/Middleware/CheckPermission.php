<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CheckPermission
{
    protected $permission;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var $user User */
        $user = Auth::user();
        if (!$user->hasPermissionTo($this->permission)) {
            throw new AccessDeniedHttpException('You do not allowed to this area');
        }
        return $next($request);
    }
}
