<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== $role && $role !== 'admin' && !auth()->user()->isAdmin()) {
            abort(403, 'Нямате права за достъп до тази страница.');
        }

        if ($role === 'admin' && !auth()->user()->isAdmin()) {
            abort(403, 'Само администратори имат достъп до тази страница.');
        }

        return $next($request);
    }
}
