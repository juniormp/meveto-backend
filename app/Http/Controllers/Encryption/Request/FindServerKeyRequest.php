<?php


namespace App\Http\Controllers\Encryption\Request;


use App\Http\Controllers\BaseRequest;


class FindServerKeyRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:3', 'max:20', 'exists:users'],
        ];
    }

    public function getData(): array
    {
        return array_merge($this->only(['username']));
    }
}
