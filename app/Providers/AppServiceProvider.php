<?php

namespace App\Providers;

use App\Infrastructure\Repository\Auth\IUserRepository;
use App\Infrastructure\Repository\Auth\UserRepository;
use App\Infrastructure\Repository\Encryption\IKeyRepository;
use App\Infrastructure\Repository\Encryption\KeyRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $bindings = [

        //Repository
        IUserRepository::class => UserRepository::class,
        IKeyRepository::class => KeyRepository::class

    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
