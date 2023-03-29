<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->registerPolicies();

        Passport::tokensExpireIn(now()->addDays(1));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            if (config('app.env') != 'local') {
                $token = substr($url, strpos($url, 'verify/') + 7);
                $url = config('app.frontend_url').'/#/verify;id='.$token;
            }

            return (new MailMessage())
                ->subject('Verify Email Address')
                ->line('Click the button below to verify your email address.')
                ->action('Verify Email Address', $url);
        });

        ResetPassword::createUrlUsing(function ($user, string $token) {
            $url = 'http://wahtermelon.test/api/v1/reset-password?token=';
            if (config('app.env') != 'local') {
                $url = config('app.frontend_url').'/#/reset-password?token=';
            }

            return $url.$token.'&email='.urlencode($user->email);
        });
    }
}
