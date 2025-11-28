<?php

namespace app\Http\Controllers\;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // POST /users/login
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('username', $validated['username'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Create a Sanctum token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    // GET /users/me
    public function me(Request $request)
    {
        return $request->user();
    }

    // PUT /users/me/password
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'new_password' => 'required|string|min:6'
        ]);

        $user = $request->user();
        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return response()->json(['message' => 'Password updated']);
    }
}
