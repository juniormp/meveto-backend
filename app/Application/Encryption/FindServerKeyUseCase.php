<?php


namespace App\Application\Encryption;


use App\Application\Encryption\Command\FindServerKeyCommand;
use App\Infrastructure\Repository\Auth\IUserRepository;
use App\Infrastructure\Repository\Encryption\IKeyRepository;

class FindServerKeyUseCase
{
    private IKeyRepository $keyRepository;
    private IUserRepository $userRepository;

    public function __construct(IKeyRepository $keyRepository, IUserRepository $userRepository)
    {
        $this->keyRepository = $keyRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(FindServerKeyCommand $command): string
    {
        $user = $this->userRepository->findByUsername($command->username);
        $key = $this->keyRepository->findByUserId($user->id);

        return $key->public_key;
    }
}
