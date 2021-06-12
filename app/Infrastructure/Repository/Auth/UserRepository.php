<?php


namespace App\Infrastructure\Repository\Auth;


use App\Domain\Auth\User;
use App\Infrastructure\Repository\BaseRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    private $model = User::class;

    public function __construct()
    {
        parent::__construct($this->model);
    }
}
