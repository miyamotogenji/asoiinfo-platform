<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || !$user->two_factor_confirmed) {
            return $next($request);
        }

        if (session('2fa_verified')) {
            return $next($request);
        }

        // Allow 2FA routes themselves
        if ($request->routeIs('admin.two-factor.*')) {
            return $next($request);
        }

        return redirect()->route('admin.two-factor.challenge');
    }
}
