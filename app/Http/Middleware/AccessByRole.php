<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessByRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$allowedRoles)
    {
        $user = auth()->user();
        $role = $user?->roles->first()->id ?? null;

        if (!in_array($role, $allowedRoles)) {
            return redirect()->route(match ($role) {
                3 => 'customer.dashboard',
                default => 'index'
            });
        }
        return $next($request);
    }
}
