<?php


namespace App\Application\Encryption\Command;

/**
 * @property string $username
 * @property string $secretName,
 * @property string $encryptedSecret
 */
class StoreSecretDataCommand
{
    public string $username;

    public function __construct($data)
    {
        $this->username = $data['username'];
        $this->secretName = $data['secret_name'];
        $this->encryptedSecret = $data['encrypted_secret'];
    }
}
