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
            'users-index' => 'Usuários',
            'users-store' => 'Usuários',
            'users-update' => 'Usuários',
            'users-destroy' => 'Usuários',
            'users-show' => 'Usuários',

            'user-r-groups-index' => 'USUÁRIOS & GRUPOS',
            'user-r-groups-store' => 'USUÁRIOS & GRUPOS',
            'user-r-groups-destroy' => 'USUÁRIOS & GRUPOS',

            'groups-index' => 'Grupos',
            'groups-store' => 'Grupos',
            'groups-update' => 'Grupos',
            'groups-destroy' => 'Grupos',
            'groups-show' => 'Grupos',

            'group-r-roles-index' => 'GRUPOS & FUNÇÕES',
            'group-r-roles-store' => 'GRUPOS & FUNÇÕES',
            'group-r-roles-destroy' => 'GRUPOS & FUNÇÕES',

            'roles-index' => 'Funções',
            'roles-store' => 'Funções',
            'roles-update' => 'Funções',
            'roles-destroy' => 'Funções',
            'roles-show' => 'Funções',

            'role-r-scopes-index' => 'FUNÇÕES & EXTENÇÕES',
            'role-r-scopes-store' => 'FUNÇÕES & EXTENÇÕES',
            'role-r-scopes-destroy' => 'FUNÇÕES & EXTENÇÕES',

            'scopes-index' => 'Extenções',
            'scopes-store' => 'Extenções',
            'scopes-update' => 'Extenções',
            'scopes-destroy' => 'Extenções',
            'scopes-show' => 'Extenções',
        ]);

        $this->registerPolicies();

        // valida usuário
        Passport::routes();

        // define o tempo que o token e o refresh token tem de vida
        Passport::tokensExpireIn(now()->addDays(2));
        Passport::refreshTokensExpireIn(now()->addDays(5));

    }
}
