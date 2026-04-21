<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated= $request-> validate([
            'name'=> 'required|string|max:50',
            'email'=>'required|email|unique:users,email',
            'password' => 'required|min:6',]);

        return User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
           'password' => Hash::make($validated['password']),
        ]);
    
 return response()->json([
        'message' => 'User registered successfully',
        'user' => $user
    ]);
}
   public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // remove old tokens
    $user->tokens()->delete();

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ],
        'token' => $token
    ]);
}


}


