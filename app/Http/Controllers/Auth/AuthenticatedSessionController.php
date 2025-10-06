<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email_or_username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $emailOrUsername = $request->email_or_username;
        $password = $request->password;

        // Determine if input is email or username
        $isEmail = filter_var($emailOrUsername, FILTER_VALIDATE_EMAIL);
        
        $user = null;
        if ($isEmail) {
            // Try to authenticate with email
            $user = \App\Models\User::where('email', $emailOrUsername)
                ->where('role', 'parent')
                ->first();
        } else {
            // Try to authenticate with username
            $user = \App\Models\User::where('username', $emailOrUsername)
                ->where('role', 'parent')
                ->first();
        }

        if (!$user || !\Illuminate\Support\Facades\Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email_or_username' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Login successful'
        ], 200);
    }

    /**
     * Login for children using username instead of email
     */
    public function childLogin(Request $request): JsonResponse
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Find user by username
        $user = \App\Models\User::where('username', $request->username)
            ->where('role', 'child')
            ->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Child login successful'
        ], 200);
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ], 200);
    }
}
