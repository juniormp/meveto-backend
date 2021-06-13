<?php


namespace App\Http\Controllers\Encryption\Response;



class FindSecretResponse
{
    public static function build(string $encryptedSecret): array
    {
        return [
            'encrypted_secret' => $encryptedSecret,
        ];
    }
}
