<?php


namespace App\Http\Controllers\Encryption\Response;


use App\Domain\Auth\User;

class FindServerKeyResponse
{
    public static function build(string $publicKey): array
    {
        return [
            'public_key' => $publicKey,
        ];
    }
}
