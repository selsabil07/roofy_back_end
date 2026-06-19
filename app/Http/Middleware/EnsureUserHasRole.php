<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Roofy API: Restricts routes to users with one of the allowed roles.
 * Used to separate admin dashboard routes from agent dashboard routes.
 */
class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! in_array($user->role, $roles, true)) {
            return response()->json([
                'message' => 'Unauthorized. Required role: '.implode(' or ', $roles),
            ], 403);
        }

        return $next($request);
    }
}
