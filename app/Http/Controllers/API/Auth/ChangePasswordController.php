<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    public function passwordResetProcess(UpdatePasswordRequest $request)
    {
        $response = Password::reset($request->validated(), function ($user, $password) {
            if ((Hash::check(request('password'), $user->password)) == true) {
                throw ValidationException::withMessages([
                    'message' => 'Please enter a password which is not similar to current password.',
                ]);
            }
            $user->password = $password;
            $user->save();
            event(new PasswordReset($user));
        });

        if ($response == Password::PASSWORD_RESET) {
            return response()->json(['status' => 200, 'message' => trans($response)]);
        }

        throw ValidationException::withMessages([
            'message' => [trans($response)],
        ]);
    }
}
