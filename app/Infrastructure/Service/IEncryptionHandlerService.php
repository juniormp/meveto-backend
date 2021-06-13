<?php


namespace App\Infrastructure\Service;


use App\Domain\Auth\User;
use App\Domain\Storage\Storage;

interface IEncryptionHandlerService
{
    function canDecryptWithServerKey(string $encryptedSecret): string;

    function decryptWithServerKeyAndEncryptWithUserKey(User $user, Storage $storage): string;
}
