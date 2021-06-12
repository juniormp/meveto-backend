<?php


namespace App\Http\Controllers\Auth\Request;


use App\Http\Controllers\BaseRequest;


class RegisterRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:3', 'max:20', 'unique:users'],
            'public_key' => ['required', 'string', 'unique:users'], // validation for public key
        ];
    }

    public function getData(): array
    {
        return array_merge($this->only(['username', 'public_key']));
    }
}
