<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // GET /api/users
    public function index()
    {
        return User::all();
    }

    // GET /api/users/{id}
    public function show($id)
    {
        return User::findOrFail($id);
    }

    // POST /api/users
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        return User::create($validated);
    }

    // PUT /api/users/{id}
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => 'sometimes|string',
            'email' => 'sometimes|string|email',
            'password' => 'sometimes|string'
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return $user;
    }

    // DELETE /api/users/{id}
    public function destroy($id)
    {
        return User::destroy($id);
    }

    // POST /api/users/login
    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid login'], 401);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    // GET /api/users/me
    public function me(Request $request)
    {
        return $request->user();
    }

    // PUT /api/users/me/password (FIXED)
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        try {
            $validated = $request->validate([
                'password' => ['required', 'string', 'min:4'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors(),
            ], 422);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return response()->json(['message' => 'Password updated']);
    }

    // GET /api/users/{id}/friends
    public function friends($id)
    {
        $user = User::findOrFail($id);
        return $user->friends;
    }

    // POST /api/users/{id}/friends
    public function addFriend(Request $request, $id)
    {
        $request->validate([
            'friend_id' => 'required|integer|exists:users,id'
        ]);

        Friend::create([
            'user_id' => $id,
            'friend_id' => $request->friend_id
        ]);

        return response()->json(['message' => 'Friend added']);
    }
}
