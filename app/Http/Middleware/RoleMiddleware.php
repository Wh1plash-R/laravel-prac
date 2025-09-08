<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if(!Auth::check()) {
            return redirect()->route('welcome');
        }
        $user = Auth::user();


        if ($user->hasRole($role)) {
                return $next($request);
            }

        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }
}
