<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class ApiProtectedRoute extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        try {

            JWTAuth::parseToken()->authenticate();

            return $next($request);
        } catch (\Exception $e) {
            Log::info($e);
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['message' => 'Sessão Inválido!'], 401);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['message' => 'Sessão Expirado!'], 401);
            } else {
                return response()->json(['message' => 'Sessão não existe!'], 401);
            }
        }

        return $next($request);
    }
}
