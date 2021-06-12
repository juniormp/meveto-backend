<?php


namespace App\Domain\Auth;


use App\Application\Auth\Command\RegisterUserCommand;

class UserFactory
{
    public function create(RegisterUserCommand $command): User
    {
        return User::create([
            'username' => $command->username,
            'public_key' => $command->public_key
        ]);
    }
}
