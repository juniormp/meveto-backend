<?php


namespace App\Infrastructure\Service;


interface IEncryptionHandlerService
{
    function decryptWithUserKeyAndEncryptWithServerKey(string $userPublicKey, string $encryptedSecret): string;
}
