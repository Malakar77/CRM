<?php

namespace App\Providers;
use Laravel\Passport\Passport;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

            $this->registerPolicies();

            Passport::tokensExpireIn(now()->addDays(15)); // Срок действия токенов
            Passport::refreshTokensExpireIn(now()->addDays(30)); // Срок действия refresh-токенов
            Passport::personalAccessTokensExpireIn(now()->addMonths(6)); // Срок персональных токенов


//        Passport::routes();
    }
}
