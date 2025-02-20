<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/library.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            /* return Limit::perMinute(120)
                //->by($request->user()?->id ?: $request->ip());
                ->by($request->user()?->id ?? $request->ip() . ':' . $request->userAgent()); */
            /* return [
                Limit::perMinute(600)->by($request->user()?->id ?: $request->ip()),
                Limit::perHour(20000)->by($request->user()?->id ?: $request->ip()),
            ]; */
            // For authenticated users
            if ($request->user()) {
                return [
                    // Individual user limit
                    Limit::perMinute(600)->by($request->user()->id),
                    // Additional shared IP limit for authenticated users
                    Limit::perMinute(6000)->by('auth:api:' . $request->ip())
                ];
            }

            // For unauthenticated users behind shared IPs
            return [
                Limit::perMinute(3000)->by($request->ip()),
                Limit::perSecond(100)->by($request->ip()),
                // Add a decay rate for sustained high traffic
                Limit::perHour(30000)->by($request->ip())
            ];
        });
    }
}
