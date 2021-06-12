<?php


namespace App\Infrastructure\Repository\Encryption;


use App\Domain\Encryption\Key;
use App\Infrastructure\Repository\IBaseRepository;

interface IKeyRepository extends IBaseRepository
{
    public function findByUserId(int $userId): Key;
}
