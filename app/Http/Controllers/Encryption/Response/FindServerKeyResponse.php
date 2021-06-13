<?php


namespace App\Http\Controllers\Encryption\Response;



class FindServerKeyResponse
{
    public static function build(string $publicKey = null): array
    {
        return [
            'public_key' => $publicKey,
        ];
    }
}
