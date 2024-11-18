<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        $token = $user->createToken(User::TOKEN_NAME)->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
