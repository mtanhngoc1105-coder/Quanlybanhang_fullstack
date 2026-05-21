<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\JwtService;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        // If user doesn't exist, create a new buyer account
        if (!$user) {
            $user = User::create([
                'name' => explode('@', $request->email)[0], // Use part before @ as name
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'buyer',
                'points' => 0,
            ]);
        } else {
            // If user exists, verify password
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sai email hoặc mật khẩu',
                ], 401);
            }
        }

        $token = JwtService::createToken([
            'sub' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'iat' => time(),
            'exp' => time() + (int) env('JWT_EXPIRES_IN', 3600),
        ]);

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'points' => $user->points,
            ],
        ]);
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'points' => $user->points,
            ],
        ]);
    }
}
