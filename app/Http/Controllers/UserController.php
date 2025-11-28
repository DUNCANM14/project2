<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $TOKEN = "mysecrettoken123";

    private function authCheck(Request $request)
    {
        $header = $request->header('Authorization');
        if (!$header) return false;

        $token = trim(str_replace('Bearer', '', $header));
        return $token === $this->TOKEN;
    }

    // GET /users
    public function index()
    {
        return User::select('id', 'username', 'email', 'created_at')->get();
    }

    // GET /users/{id}
    public function show($id)
    {
        $user = User::select('id','username','email','created_at')->find($id);
        if (!$user) return response()->json(['error'=>'User not found'], 404);

        return $user;
    }

    // POST /users
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'email'    => 'required|email',
            'password' => 'required|string'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return response()->json(['message' => 'User created']);
    }

    // POST /users/login
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('username', $validated['username'])->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json(['error' => 'Invalid password'], 401);
        }

        return response()->json(['token' => $this->TOKEN]);
    }

    // GET /users/me
    public function me(Request $request)
    {
        if (!$this->authCheck($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'id' => 1,
            'username' => 'demo',
            'email' => 'demo@example.com'
        ]);
    }

    // PUT /users/me/password
    public function updatePassword(Request $request)
    {
        if (!$this->authCheck($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'new_password' => 'required|string'
        ]);

        $newHash = Hash::make($validated['new_password']);

        User::where('id', 1)->update(['password' => $newHash]);

        return response()->json(['message' => 'Password updated']);
    }

    // PUT /users/{id}
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['error'=>'User not found'], 404);

        $user->update([
            'username' => $request->username,
            'email'    => $request->email
        ]);

        return response()->json(['message'=>'User updated']);
    }

    // DELETE /users/{id}
    public function destroy(Request $request, $id)
    {
        if (!$this->authCheck($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::find($id);
        if (!$user) return response()->json(['error'=>'User not found'], 404);

        $user->delete();
        return response()->json(['message'=>'User deleted']);
    }

    // GET /users/{id}/friends
    public function friends($id)
    {
        return Friend::where('user_id', $id)
            ->with('friendUser:id,username,email')
            ->get()
            ->map(fn ($f) => $f->friendUser);
    }

    // POST /users/{id}/friends
    public function addFriend(Request $request, $id)
    {
        if (!$this->authCheck($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'friend_id' => 'required|integer'
        ]);

        Friend::create([
            'user_id' => $id,
            'friend_id' => $validated['friend_id']
        ]);

        return response()->json(['message'=>'Friend added']);
    }
}
