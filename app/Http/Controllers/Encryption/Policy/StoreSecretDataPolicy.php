<?php


namespace App\Http\Controllers\Encryption\Policy;


use App\Infrastructure\Auth\SignatureValidatorService;

class StoreSecretDataPolicy
{
    private SignatureValidatorService $signatureValidatorService;

    public function __construct(SignatureValidatorService $signatureValidatorService)
    {
        $this->signatureValidatorService = $signatureValidatorService;
    }

    public function validate(string $username, string $signature): bool
    {
        return $this->signatureValidatorService->validateSignature($username, $signature);
    }
}
