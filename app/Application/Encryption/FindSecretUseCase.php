<?php


namespace App\Application\Encryption;


use App\Application\Encryption\Command\FindSecretCommand;
use App\Infrastructure\Repository\Auth\IUserRepository;
use App\Infrastructure\Repository\Storage\IStorageRepository;
use App\Infrastructure\Service\IEncryptionHandlerService;

class FindSecretUseCase
{
    private IEncryptionHandlerService $encryptionHandlerService;
    private IStorageRepository $storageRepository;
    private IUserRepository $userRepository;

    public function __construct(
        IEncryptionHandlerService $encryptionHandlerService,
        IStorageRepository $storageRepository,
        IUserRepository $userRepository
    )
    {
        $this->encryptionHandlerService = $encryptionHandlerService;
        $this->storageRepository = $storageRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(FindSecretCommand $command): string
    {
        $storage = $this->storageRepository->findSecretByName($command->secretName);
        $user = $this->userRepository->findByUsername($command->username);

        return $this->encryptionHandlerService
            ->decryptWithServerKeyAndEncryptWithUserKey($user, $storage);
    }
}
