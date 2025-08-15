<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (Auth::guest()) {
            return redirect()->route('login');
        }

        $allowedRoles = explode('|', $roles);

        $userRole = Auth::user()->role->role_name ?? null;

        if (!$userRole || !in_array($userRole, $allowedRoles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}