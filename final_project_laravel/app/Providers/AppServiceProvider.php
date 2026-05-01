<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\ApplicationStatusUpdated::class,
            \App\Listeners\LogAuditTrail::class
        );

        \Illuminate\Support\Facades\Event::listen(
            \App\Events\ApplicationStatusUpdated::class,
            \App\Listeners\SendStatusNotification::class
        );

        \Illuminate\Support\Facades\Event::listen(
            \App\Events\ApplicationCancelled::class,
            \App\Listeners\NotifyCancellation::class
        );

        \Illuminate\Support\Facades\Event::listen(
            \App\Events\ApplicationArchived::class,
            \App\Listeners\CleanupAssets::class
        );

        \Illuminate\Support\Facades\RateLimiter::for('inquiry', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($request->ip());
        });
    }
}
