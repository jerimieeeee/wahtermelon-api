<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class AuthenticationController extends Controller
{
    /**
     * User Login API
     *
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = User::where('email', $request->email)->first(); //change from contact_number to username
        /*$abilities = $user->roles->pluck('permissions')->flatten()->pluck('slug')->toArray();
        if (!$user->roles->isEmpty() && auth()->user()->isSuperAdmin()) {
            $abilities = ["*"];
        }*/

        $tokenResult = $user->createToken(request()->ip())->accessToken;

        return response()->json([
            'status_code' => 200,
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => Auth::user()->load('konsultaCredential') ?? Auth::user(),
        ])->withCookie(Cookie::make('access_token', $tokenResult, 3600, '/', null, true, true, true, 'None'));
    }

    /**
     * User Logout API
     *
     * @authenticated
     *
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        /*
         * This will log the user out from the current device where he requested to log out.
         */
        $user = Auth::user()->token();
        $user->revoke();
        Cookie::queue(Cookie::forget('access_token'));

        /*
         * This will revoke all the access and refresh tokens issued to that user.
         * This will log the user out from everywhere.
         * This really comes into help when the user changes his password using reset password
         * or forget password option, and you have to log the user out from everywhere.
        $tokens =  auth()->user()->tokens->pluck('id');Token::whereIn('id', $tokens)
             ->update(['revoked'=> true]);

         RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);*/

        return response()->json([
            'status_code' => 200,
            'message' => 'You have successfully logged out!',
        ]);
    }
}
