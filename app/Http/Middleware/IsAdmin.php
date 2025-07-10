<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the admin flag
        if (!auth()->check() || !auth()->user()->is_admin) {
            // Optionally, you can redirect them or simply abort with a 403 error
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }
}
