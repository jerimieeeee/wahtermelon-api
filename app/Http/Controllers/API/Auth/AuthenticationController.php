<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    /**
     * User Login API
     *
     * @param LoginRequest $request
     * @return JsonResponse
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

        if ($user->is_active == 0) {
            throw ValidationException::withMessages([
                'account_status' => 'Account not activated!'
            ]);
        }

        $tokenResult = $user->createToken(request()->ip())->accessToken;

        return response()->json([
            'status_code' => 200,
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => Auth::user(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'status_code' => 200,
            'message' => 'You have successfully logged out!'
        ]);
    }


}
