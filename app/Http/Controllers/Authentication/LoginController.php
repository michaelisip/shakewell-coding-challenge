<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where(function ($query) use ($request) {
            $query->where('email', $request->email)
                    ->orWhere('username', $request->username);
        })->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Oops! The username or password you entered is incorrect.'],
            ]);
        }

        $token = $user->createToken(User::TOKEN_NAME)->plainTextToken;

        return response()->json([
            'message' => 'You are now logged in!',
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user('sanctum');

        if ($user) {
            $user->currentAccessToken()->delete();

            return response()->json(['message' => 'You’ve been logged out.']);
        }

        throw new UnauthorizedException('You are not logged in.');
    }
}
