<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'contact_number' => 'required|min:11|max:11',
            'username' => 'required|min:4',
            'password' => 'required|string',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('username', 'password'), $this->filled('remember'))) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'contact_number' => __('auth.failed'),
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
     * @return void
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
     *
     * @return string
     */
    public function throttleKey(): string
    {
        return Str::lower($this->input('username')).'|'.$this->ip();
    }

}
