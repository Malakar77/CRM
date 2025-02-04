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
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->prefix('main')
                ->group(base_path('routes/main.php'));

            Route::middleware('web')
                ->prefix('provider')
                ->group(base_path('routes/provider.php'));

            Route::middleware('web')
                ->prefix('logistic')
                ->group(base_path('routes/logistic.php'));

            Route::middleware('web')
                ->prefix('Attorney')
                ->group(base_path('routes/Attorney.php'));

            Route::middleware('web')
                ->prefix('manager')
                ->group(base_path('routes/manager.php'));

            Route::middleware('web')
                ->prefix('companyCall')
                ->group(base_path('routes/companyCall.php'));

            Route::middleware('web')
                ->prefix('cool')
                ->group(base_path('routes/cool.php'));

            Route::middleware('web')
                ->prefix('client')
                ->group(base_path('routes/client.php'));

            Route::middleware('web')
                ->prefix('check')
                ->group(base_path('routes/check.php'));

            Route::middleware('web')
                ->prefix('check_total')
                ->group(base_path('routes/check_total.php'));

            Route::middleware('web')
                ->prefix('profile')
                ->group(base_path('routes/profile.php'));

            Route::middleware('web')
                ->prefix('setting')
                ->group(base_path('routes/setting.php'));
        });
    }
}
