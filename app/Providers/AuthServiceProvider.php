<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Passport::tokensCan([
            'admin-users' => 'Usuários',

            'admin-groups' => 'Grupos',

            'admin-roles' => 'Funções',
        ]);

        $this->registerPolicies();

        // valida usuário
        Passport::routes();

        // define o tempo que o token e o refresh token tem de vida
        Passport::tokensExpireIn(now()->addDays(2));
        Passport::refreshTokensExpireIn(now()->addDays(5));

    }
}
