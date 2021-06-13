<?php


namespace App\Infrastructure\Service;


use Spatie\Crypto\Rsa\PrivateKey;

class EncryptionHandlerService implements IEncryptionHandlerService
{
    function decryptWithServerKey(string $encryptedSecret): string
    {
        $serverPrivateKey = PrivateKey::fromString(config('PRIVATE_KEY'));

        throw_unless($serverPrivateKey->canDecrypt(
            base64_decode($encryptedSecret)),
            new CouldNotDecryptDataException()
        );

        return $encryptedSecret;
    }
}
