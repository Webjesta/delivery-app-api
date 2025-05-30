<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        // 1) Validate everything
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users',
            'password'          => 'required|string|min:6|confirmed',
            'role'              => 'required|in:seller,customer',
            // conditional fields:
            'address'           => 'required_if:role,customer|string|max:255',
            'shop_name'         => 'required_if:role,seller|string|max:255',
        ]);

        // 2) Create the base user
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ]);

        // 3) Depending on role, fill the related table
        if ($user->role === 'customer') {
            Customer::create([
                'user_id' => $user->id,
                'address' => $data['address'],   // address column exists
            ]);
        } else { // seller
            Seller::create([
                'user_id'   => $user->id,
                'shop_name' => $data['shop_name'], // shop_name column exists
            ]);
        }

        // 4) Issue Sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
