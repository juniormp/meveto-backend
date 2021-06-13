<?php


namespace App\Application\Encryption;


use App\Application\Encryption\Command\StoreSecretDataCommand;
use App\Domain\Storage\StorageFactory;
use App\Infrastructure\Repository\Auth\IUserRepository;
use App\Infrastructure\Repository\Storage\IStorageRepository;


class StoreSecretDataUseCase
{
    private IUserRepository $userRepository;
    private StorageFactory $storageFactory;
    private IStorageRepository $storageRepository;

    public function __construct(
        IUserRepository $userRepository,
        StorageFactory $storageFactory,
        IStorageRepository $storageRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->storageFactory = $storageFactory;
        $this->storageRepository = $storageRepository;
    }

    public function execute(StoreSecretDataCommand $command): void
    {
        $user = $this->userRepository->findByUsername($command->username);
        $storage = $this->storageFactory->create($user, $command->secretName, $command->encryptedSecret);
        $this->storageRepository->save($storage);
    }
}
