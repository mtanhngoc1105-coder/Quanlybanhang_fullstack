<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\JwtService;
use App\Models\User;

class JwtAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // return $next($request);
        $header = $request->header('Authorization', '');
        $token = str_starts_with($header, 'Bearer ') ? substr($header, 7) : null;

        if (!$token) {
            // dd('Không tìm thấy token trong header');
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $payload = JwtService::validateToken($token);
        if (!$payload || empty($payload['sub'])) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $user = User::find($payload['sub']);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $request->setUserResolver(fn () => $user);
        $request->merge(['auth_user' => $user]);

        return $next($request);
    }
}
