<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        // Validasi kredensial login
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // // Generasi token (menggunakan Laravel Passport atau Sanctum)
            $token = $user->createToken('YourAppName')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'role' => $user->role,
            ]);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
}
