<?php


namespace App\Application\Encryption;


use App\Application\Encryption\Command\FindServerKeyCommand;
use App\Application\Encryption\Command\StoreSecretDataCommand;
use App\Infrastructure\Repository\Auth\IUserRepository;
use App\Infrastructure\Repository\Encryption\IKeyRepository;
use phpseclib3\Crypt\RSA;

class StoreSecretDataUseCase
{
    private IKeyRepository $keyRepository;
    private IUserRepository $userRepository;

    public function __construct(IKeyRepository $keyRepository, IUserRepository $userRepository)
    {
        $this->keyRepository = $keyRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(StoreSecretDataCommand $command): string
    {
        $user = $this->userRepository->findByUsername($command->username);

        $key = RSA::load($user->key->public_key);

        dd($key-);

        $key = $this->keyRepository->findByUserId($user->id);

        return $key->public_key;
    }
}
