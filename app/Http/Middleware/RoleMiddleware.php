<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Check if user is authenticated
        if (!$request->user()) {
            return $this->unauthorizedResponse($request, 'Unauthenticated.');
        }

        // Check if user has any of the required roles
        if (!$request->user()->hasAnyRole($roles)) {
            return $this->unauthorizedResponse(
                $request, 
                'Unauthorized. Required role(s): ' . implode(', ', $roles)
            );
        }

        return $next($request);
    }

    /**
     * Generate appropriate unauthorized response.
     *
     * @param Request $request
     * @param string $message
     * @return Response
     */
    protected function unauthorizedResponse(Request $request, string $message): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
            ], 403);
        }

        abort(403, $message);
    }
}
