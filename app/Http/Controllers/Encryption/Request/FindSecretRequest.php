<?php


namespace App\Http\Controllers\Encryption\Request;


use App\Domain\Auth\User;
use App\Http\Controllers\BaseRequest;
use App\Http\Controllers\Encryption\Policy\FindSecretPolicy;
use Illuminate\Validation\Rule;


class FindSecretRequest extends BaseRequest
{
    private FindSecretPolicy $findSecretPolicy;

    public function __construct(FindSecretPolicy $findSecretPolicy)
    {
        $this->findSecretPolicy = $findSecretPolicy;
    }

    public function authorize(): bool
    {
        return $this->findSecretPolicy->validate($this->getData()['username'], $this->header('signature'));
    }

    public function rules(): array
    {
        return [
            'username' => ['bail', 'required', 'string', 'min:3', 'max:20', 'exists:users'],
            'secret_name' => ['required', 'string', 'min:3', Rule::exists('storages')->where(function ($query) {
                $user = User::where('username', $this->username)->first();
                if (!is_null($user)) {
                    return $query->where('user_id', $user->id);
                }
            }),]
        ];
    }

    public function getData(): array
    {
        return array_merge($this->only(['username', 'secret_name']));
    }
}
