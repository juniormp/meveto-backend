<?php


namespace App\Http\Controllers\Encryption\Response;



class FindServerKeyResponse
{
    public static function build(string $publicKey): array
    {
        return [
            'public_key' => $publicKey,
        ];
    }
}
