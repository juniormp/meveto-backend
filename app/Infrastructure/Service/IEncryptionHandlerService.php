<?php


namespace App\Infrastructure\Service;


interface IEncryptionHandlerService
{
    function decryptWithServerKey(string $encryptedSecret): string;
}
