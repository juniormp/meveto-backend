<?php


namespace App\Application\Auth;


use App\Application\Auth\Command\RegisterUserCommand;
use App\Domain\Auth\User;
use App\Domain\Auth\UserFactory;
use App\Domain\Encryption\KeyFactory;
use App\Infrastructure\Repository\Auth\IUserRepository;
use App\Infrastructure\Repository\Encryption\IKeyRepository;
use App\Infrastructure\Repository\Encryption\KeyRepository;

class RegisterUserUseCase
{
    private UserFactory $userFactory;
    private IUserRepository $userRepository;
    private KeyFactory $keyFactory;
    private IKeyRepository $keyRepository;

    public function __construct(
        UserFactory $userFactory,
        IUserRepository $userRepository,
        KeyFactory $keyFactory,
        KeyRepository $keyRepository
    )
    {
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
        $this->keyFactory = $keyFactory;
        $this->keyRepository = $keyRepository;
    }

    public function execute(RegisterUserCommand $command): User
    {
        $user = $this->userFactory->create($command);
        $user = $this->userRepository->save($user);

        $key = $this->keyFactory->create($user->id, $command->public_key);
        $this->keyRepository->save($key);

        return $user;
    }
}
