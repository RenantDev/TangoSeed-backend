<?php

namespace App\Providers;

use App\Repositories\AclRepository;
use App\Repositories\AclRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class AclRepositoryProvider extends ServiceProvider
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
        $this->app->bind(AclRepository::class, AclRepositoryEloquent::class);
    }
}
