<?php


namespace App\Infrastructure\Repository\Auth;


use App\Domain\Auth\User;
use App\Infrastructure\Repository\IBaseRepository;

interface IUserRepository extends IBaseRepository
{
    public function findByUsername(string $username): User;
}
