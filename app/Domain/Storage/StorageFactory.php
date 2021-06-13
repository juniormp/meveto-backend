<?php


namespace App\Domain\Storage;


use App\Domain\Auth\User;
use App\Infrastructure\Service\IEncryptionHandlerService;

class StorageFactory
{
    private IEncryptionHandlerService $encryptionHandlerService;

    public function __construct(IEncryptionHandlerService $encryptionHandlerService)
    {
        $this->encryptionHandlerService = $encryptionHandlerService;
    }

    public function create(User $user, string $secretName, string $encryptedSecret): Storage
    {
        return new Storage([
            'user_id' => $user->id,
            'secret_name' => $secretName,
            'encrypted_secret' => $this->encryptionHandlerService
                ->decryptWithUserKeyAndEncryptWithServerKey($user->key->public_key, $encryptedSecret)
        ]);
    }
}
