<?php


namespace App\Domain\Encryption;


use phpseclib3\Crypt\RSA;

class KeyFactory
{
    public function create(int $userId)
    {
        $privateKey = RSA::createKey();
        $publicKey = $privateKey->getPublicKey();

        return new Key([
            'user_id' => $userId,
            'public_key' => $privateKey->toString('PKCS8'),
            'private_key' => $publicKey->toString('PKCS8')
        ]);
    }
}
