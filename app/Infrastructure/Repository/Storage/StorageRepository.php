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

    public function save($model): Storage
    {
        return Storage::updateOrCreate([
            'user_id' => $model->user_id,
            'secret_name' => $model->secret_name
        ], [
           'encrypted_secret' => $model->encrypted_secret
        ]);
    }

    public function findSecretByName(string $secretName): Storage
    {
        return Storage::where('secret_name', $secretName)->first();
    }
}
