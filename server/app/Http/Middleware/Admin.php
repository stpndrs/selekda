<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $findToken = PersonalAccessToken::findToken($request->bearerToken());

        if (!$findToken) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = $findToken->tokenable;

        if ($user && $user instanceof User) {
            $level = $user->level; // Asumsikan ada kolom 'level' pada tabel users
            // Lakukan sesuatu dengan level, misalnya:
            if ($level != 1) { // Misalnya hanya user dengan level >= 5 yang diizinkan
                return response()->json(['message' => 'Forbidden'], 403);
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 404);
        }

        return $next($request);
    }
}
