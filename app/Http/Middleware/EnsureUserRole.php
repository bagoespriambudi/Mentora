<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        Log::info('Role Middleware', [
            'user_role' => $request->user()?->role,
            'required_role' => $role,
            'is_authenticated' => $request->user() ? 'yes' : 'no',
            'path' => $request->path()
        ]);

        if (!$request->user() || $request->user()->role !== $role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}