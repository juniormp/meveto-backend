<?php


namespace App\Http\Controllers\Encryption\Request;


use App\Http\Controllers\BaseRequest;


class StoreSecretDataRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:3', 'max:20', 'exists:users'],
            'secret_name' => ['required', 'string', 'min:3', 'max:500'],
            'encrypted_secret' => ['required', 'string', 'min:3', 'max:500'],
        ];
    }

    public function getData(): array
    {
        return array_merge($this->only(['username', 'secret_name', 'encrypted_secret']));
    }
}
