<?php


namespace App\Domain\Encryption;


class KeyFactory
{
    public function create(int $userId, string $publicKey): Key
    {
        return new Key([
            'user_id' => $userId,
            'public_key' => $publicKey,
        ]);
    }
}
