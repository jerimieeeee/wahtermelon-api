<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // 'contact_number' => 'required|min:11|max:11',
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->filled('remember'))) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'contact_number' => __('auth.failed'),
            ]);
        }

        if (is_null(Auth::user()->email_verified_at)) {
            event(new Registered(Auth::user()));
            throw ValidationException::withMessages([
                'account_status' => 'Your email address is not verified. You need to confirm your account. We have sent you an activation code, please check your email.',
            ]);
        }

        if (Auth::user()->is_active == 0) {
            throw ValidationException::withMessages([
                'account_status' => 'Account not activated!',
            ]);
        }

        //validate if mobile is verified for existing users, else send OTP SMS
        /*if(is_null(Auth::user()->mobile_verified_at)){
            $otp =  OtpValidator::requestOtp(new OtpRequestObject(Auth::user()->id,'',Auth::user()->contact_number,Auth::user()->email));
            throw ValidationException::withMessages([
                'contact_number' => __('auth.mobile_verified'),
                'otp' => array($otp)
            ]);
        }*/

        //Delete existing token of user
        //auth()->user()->tokens()->delete();
        //$this->createAudit('login', 'Laravel\Sanctum\PersonalAccessToken');
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'contact_number' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}
