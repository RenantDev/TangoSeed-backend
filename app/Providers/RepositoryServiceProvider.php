<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\ProfileRepository::class, \App\Repositories\ProfileRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GroupRepository::class, \App\Repositories\GroupRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoleRepository::class, \App\Repositories\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ScopeRepository::class, \App\Repositories\ScopeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GroupRRoleRepository::class, \App\Repositories\GroupRRoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserRGroupRepository::class, \App\Repositories\UserRGroupRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoleRScopeRepository::class, \App\Repositories\RoleRScopeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\LoginRepository::class, \App\Repositories\LoginRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoleCategoryRepository::class, \App\Repositories\RoleCategoryRepositoryEloquent::class);
        //:end-bindings:
    }
}
