<?php

namespace App\Providers;

use App\Infrastructure\Repository\Auth\IUserRepository;
use App\Infrastructure\Repository\Auth\UserRepository;
use App\Infrastructure\Repository\Encryption\IKeyRepository;
use App\Infrastructure\Repository\Encryption\KeyRepository;
use App\Infrastructure\Repository\Storage\IStorageRepository;
use App\Infrastructure\Repository\Storage\StorageRepository;
use App\Infrastructure\Service\EncryptionHandlerService;
use App\Infrastructure\Service\IEncryptionHandlerService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $bindings = [

        //Repository
        IUserRepository::class => UserRepository::class,
        IKeyRepository::class => KeyRepository::class,
        IEncryptionHandlerService::class => EncryptionHandlerService::class,
        IStorageRepository::class => StorageRepository::class

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
