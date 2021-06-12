<?php


namespace App\Infrastructure\Repository\Encryption;


use App\Domain\Encryption\Key;
use App\Infrastructure\Repository\BaseRepository;

class KeyRepository extends BaseRepository implements IKeyRepository
{
    private $model = Key::class;

    public function __construct()
    {
        parent::__construct($this->model);
    }

    public function findByUserId(int $userId): Key
    {
        return Key::where('user_id', $userId)->first();
    }
}
