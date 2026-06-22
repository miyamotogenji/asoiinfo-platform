<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        if (!$request->user() || !$request->user()->hasAnyRole($roles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Acceso denegado.'], 403);
            }
            return redirect()->route('admin.dashboard')->with('error', 'No tiene permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
