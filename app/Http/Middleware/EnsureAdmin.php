<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (! $user || ! in_array($user->role, ['admin', 'moderator'], true)) {
            abort(403);
        }

        return $next($request);
    }
}
