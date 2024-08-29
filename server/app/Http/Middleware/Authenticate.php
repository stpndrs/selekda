<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return null;
    }

    /**
     * Handle unauthenticated users.
     */
    protected function unauthenticated($request, array $guards)
    {
        if ($request->expectsJson()) {
            response()->json(['message' => 'Unauthenticated'], 401)->send();
            exit;
        }

        response()->json(['message' => 'Unauthenticated'], 401)->send();
        exit;
    }
}
