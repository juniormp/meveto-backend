<?php


namespace App\Http\Controllers\Auth\Response;


use App\Domain\Auth\User;

class RegisterResponse
{
    public static function build(User $user): array
    {
        return [
            'username' => $user->username,
        ];
    }
}
