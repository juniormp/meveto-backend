<?php


namespace App\Application\Encryption\Command;

/**
 * @property string $username
 */
class FindServerKeyCommand
{
    public string $username;

    public function __construct($data)
    {
        $this->username = $data['username'];
    }
}
