<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        
        if(Auth::attempt($credentials))
            return new User(Auth::user());
        else
            return response()->json(['errors' => ['password' => [__('auth.failed')]]], 401);
    }

    public function register(RegisterRequest $request, ModelsUser $user)
    {
        $credentials = $request->only(['email', 'password']);

        $user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if(Auth::attempt($credentials))
            return new User(Auth::user());
        else
            return response()->json(['errors' => ['password' => [__('auth.failed')]]], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'You logged out']);
    }
}
