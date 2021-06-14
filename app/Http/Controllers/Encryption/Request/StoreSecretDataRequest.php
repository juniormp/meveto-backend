<?php


namespace App\Http\Controllers\Encryption\Request;


use App\Exceptions\Controllers\InvalidSignatureException;
use App\Http\Controllers\BaseRequest;
use App\Http\Controllers\Encryption\Policy\StoreSecretDataPolicy;


class StoreSecretDataRequest extends BaseRequest
{
    private StoreSecretDataPolicy $secretDataPolicy;

    public function __construct(StoreSecretDataPolicy $findSecretPolicy)
    {
        $this->secretDataPolicy = $findSecretPolicy;
    }

    public function authorize(): bool
    {
        throw_if(is_null($this->header('signature')), new InvalidSignatureException());

        return $this->secretDataPolicy->validate($this->getData()['username'], $this->header('signature'));
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:3', 'max:20', 'exists:users'],
            'secret_name' => ['required', 'string', 'min:3', 'max:100'],
            'encrypted_secret' => ['required', 'string', 'min:3']
        ];
    }

    public function getData(): array
    {
        return array_merge($this->only(['username', 'secret_name', 'encrypted_secret']));
    }
}
