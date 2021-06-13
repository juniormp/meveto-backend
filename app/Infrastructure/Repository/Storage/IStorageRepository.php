<?php


namespace App\Infrastructure\Repository\Storage;


use App\Domain\Storage\Storage;
use App\Infrastructure\Repository\IBaseRepository;

interface IStorageRepository extends IBaseRepository
{
    public function findSecretByName(string $secretName): Storage;
}
