<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json(['message'=>'Logged out']);
    }
}
