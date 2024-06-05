<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\error;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username',
            'password'
        ]);

        $credentials = $request->only('username', 'password');

        $token = auth()->attempt($credentials);

        if(!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => [
                    'username' => $user->username,
                    'email' => $user->email,
                    'token' => $token,
                ]
        ]);
    }

    public function register(Request $request) 
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => [
                'username' => $user->username,
                'email' => $user->email,
                'token' => $token,
            ]
        ]);
    }

    
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        $user = Auth::user();
        $token = Auth::refresh();
        
        return response()->json([
            'status' => 'success',
            'user' => [
                'username' => $user->username,
                'email' => $user->email,
                'token' => $token,
            ]
        ]);
    }

}
