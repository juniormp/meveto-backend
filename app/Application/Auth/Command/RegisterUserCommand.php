<?php


namespace App\Application\Auth\Command;

/**
 * @property string $username
 * @property string $public_key
 */
class RegisterUserCommand
{
    public string $username;
    public string $public_key;

    public function __construct($data)
    {
        $this->username = $data['username'];
        $this->public_key = $data['public_key'];
    }
}
