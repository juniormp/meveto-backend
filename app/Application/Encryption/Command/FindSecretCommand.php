<?php


namespace App\Application\Encryption\Command;

/**
 * @property string $username
 * @property string $secretName
 */
class FindSecretCommand
{
    public string $username;

    public function __construct($data)
    {
        $this->username = $data['username'];
        $this->secretName = $data['secret_name'];
    }
}
