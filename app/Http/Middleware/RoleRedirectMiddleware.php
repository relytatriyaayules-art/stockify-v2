<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRedirectMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('Admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('Manajer Gudang')) {
                return redirect()->route('manager.dashboard');
            } elseif ($user->hasRole('Staff Gudang')) {
                return redirect()->route('staff.dashboard');
            }
        }
        return $next($request);
    }
}
