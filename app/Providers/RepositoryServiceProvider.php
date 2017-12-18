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
        $this->app->bind(\App\Repositories\Api\Acl\GrupoRepository::class, \App\Repositories\Api\Acl\GrupoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Api\Acl\GrupoFuncaoRepository::class, \App\Repositories\Api\Acl\GrupoFuncaoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Api\Acl\FuncaoRepository::class, \App\Repositories\Api\Acl\FuncaoRepositoryEloquent::class);
        //:end-bindings:
    }
}
