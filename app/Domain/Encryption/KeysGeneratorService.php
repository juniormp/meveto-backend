<?php


namespace App\Domain\Encryption;


use App\Domain\Auth\User;
use App\Infrastructure\Repository\Encryption\IKeyRepository;

class KeysGeneratorService
{
    private KeyFactory $keyFactory;
    private IKeyRepository $keyRepository;

    public function __construct(KeyFactory $keyFactory, IKeyRepository $keyRepository)
    {
        $this->keyFactory = $keyFactory;
        $this->keyRepository = $keyRepository;
    }

    public function generate(User $user): void
    {
        throw_unless(is_null($user->keys), new \Exception('Keys already created'));

        $key = $this->keyFactory->create($user->id);
        $this->keyRepository->save($key);
    }
}
