<?php


namespace App\Infrastructure\Service;


use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;

class EncryptionHandlerService implements IEncryptionHandlerService
{
    public function decryptWithUserKeyAndEncryptWithServerKey(string $userPublicKey, string $encryptedSecret): string
    {
        $userPublicKey = PublicKey::fromString($userPublicKey);
        $plainText = $userPublicKey->decrypt(base64_decode($encryptedSecret));

        $serverPrivateKey =  PrivateKey::fromString((env('PRIVATE_KEY')));
        $encryptedSecret = base64_encode($serverPrivateKey->encrypt($plainText));

        return $encryptedSecret;
    }
}
