<?php


namespace App\Application\Auth;


use App\Application\Auth\Command\RegisterUserCommand;
use App\Domain\Auth\User;
use App\Domain\Auth\UserFactory;
use App\Domain\Encryption\KeysGeneratorService;
use App\Infrastructure\Repository\Auth\IUserRepository;

class RegisterUserUseCase
{
    private UserFactory $userFactory;
    private IUserRepository $userRepository;
    private KeysGeneratorService $keysGeneratorService;

    public function __construct(
        UserFactory $userFactory,
        IUserRepository $userRepository,
        KeysGeneratorService $keysGeneratorService
    )
    {
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
        $this->keysGeneratorService = $keysGeneratorService;
    }

    public function execute(RegisterUserCommand $command): User
    {
        $user = $this->userFactory->create($command);
        $this->userRepository->save($user);

        $this->keysGeneratorService->generate($user);

        return $user;
    }
}
