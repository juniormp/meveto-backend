<?php


namespace App\Infrastructure\Service;


use App\Domain\Auth\User;
use App\Domain\Storage\Storage;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;

class EncryptionHandlerService implements IEncryptionHandlerService
{
    function canDecryptWithServerKey(string $encryptedSecret): string
    {
        $serverPrivateKey = PrivateKey::fromString(env('PRIVATE_KEY'));

        throw_unless($serverPrivateKey->canDecrypt(
            base64_decode($encryptedSecret)),
            new CouldNotDecryptDataException()
        );

        return $encryptedSecret;
    }

    function decryptWithServerKeyAndEncryptWithUserKey(User $user, Storage $storage): string
    {
        $serverPrivateKey = PrivateKey::fromString(env('PRIVATE_KEY'));

        throw_unless($serverPrivateKey->canDecrypt(
            base64_decode($storage->encrypted_secret)),
            new CouldNotDecryptDataException()
        );

        $plainText = $serverPrivateKey->decrypt(base64_decode($storage->encrypted_secret));
        $userPublicKey = PublicKey::fromString($user->key->public_key);

        return base64_encode($userPublicKey->encrypt($plainText));
    }
}
