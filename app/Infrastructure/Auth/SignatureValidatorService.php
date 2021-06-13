<?php


namespace App\Infrastructure\Auth;


use App\Infrastructure\Repository\Auth\IUserRepository;
use Spatie\Crypto\Rsa\PublicKey;

class SignatureValidatorService
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validateSignature(string $username, string $signature): bool
    {
        $user = $this->userRepository->findByUsername($username);

        $publicKey = PublicKey::fromString($user->key->public_key);

        return $publicKey->verify($user->username, $signature);
    }
}
