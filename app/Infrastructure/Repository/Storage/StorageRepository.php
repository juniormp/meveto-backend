<?php


namespace App\Infrastructure\Repository\Storage;


use App\Domain\Storage\Storage;
use App\Infrastructure\Repository\BaseRepository;

class StorageRepository extends BaseRepository implements IStorageRepository
{
    private $model = Storage::class;

    public function __construct()
    {
        parent::__construct($this->model);
    }

    public function findSecretByName(string $secretName): Storage
    {
        return Storage::where('secret_name', $secretName)->first();
    }
}
