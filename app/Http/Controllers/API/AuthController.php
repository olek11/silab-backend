<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        $data = $req->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'role'     => 'user', // opsional jika pakai Spatie
        ]);

        $user->assignRole('user');

        $token = $user->createToken('lab-token')->plainTextToken;

        return response()->json([
            'user' => [
                'id'    => $user->id ?? null,
                'name'  => $user->name ?? '',
                'email' => $user->email ?? '',
                'roles' => method_exists($user, 'getRoleNames') ? $user->getRoleNames() : [$user->role ?? 'user'],
            ],
            'token' => $token ?? null
        ]);
    }

    public function login(Request $req)
    {
        $credentials = $req->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah'],
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('lab-token')->plainTextToken;

        return response()->json([
            'user' => [
                'id'    => $user->id ?? null,
                'name'  => $user->name ?? '',
                'email' => $user->email ?? '',
                'roles' => method_exists($user, 'getRoleNames') ? $user->getRoleNames() : [$user->role ?? 'user'],
            ],
            'token' => $token ?? null
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout sukses',
        ], 200);
    }
}
