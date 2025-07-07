<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\{
    RequestSignIn,
    RequestSignUp
};
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signIn(RequestSignIn $request)
    {
        $user = User::where('user_email', $request->user_email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return ApiResponse::unauthorized("Wrong Password");
        }

        $token = $user->createToken('Instapp-Token')->plainTextToken;
        return ApiResponse::success([
            'user'  => $user,
            'token' => $token
        ]);
    }

    public function signUp(RequestSignUp $request)
    {
        User::create([
            'user_name'      => $request->user_name,
            'user_full_name' => $request->user_full_name,
            'user_email'     => $request->user_email,
            'password'       => $request->password,
        ]);
        return ApiResponse::created();
    }

    public function signOut(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::success([], "Logged out successfully");
    }

    public function verify(Request $request)
    {
        return ApiResponse::success([
            'user'  => $request->user()
        ]);
    }
}
