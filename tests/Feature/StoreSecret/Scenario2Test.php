<?php


namespace Tests\Feature\StoreSecret;


use App\Domain\Auth\User;
use App\Domain\Encryption\Key;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;
use Tests\TestCase;

class Scenario2Test extends TestCase
{
    use DatabaseMigrations;

    /*
     * Application throws exception if data could not be decrypted
     *
     * GIVEN the User on terminal
     * WHEN them request /storeSecret with username, secret_name and invalid encrypted_secret
     * THEN throws could not decrypt data exception
     */
    public function test_throws_exception_if_data_could_not_be_decrypted()
    {
        $publicKey = file_get_contents('tests/app-public-key.pem');
        putenv("PUBLIC_KEY=$publicKey");
        $privateKey = file_get_contents('tests/app-private-key.pem');
        putenv("PRIVATE_KEY=$privateKey");

        $plainText = 'text to be encrypt';
        $encryptedSecret = $this->encryptDataWithServerKey($publicKey, $plainText);

        $userPublicKey = file_get_contents('tests/user-public-key.pem');
        $user = User::factory()->create(['username' => 'mauricio']);
        Key::factory()->create(['user_id' => $user->id, 'public_key' => $userPublicKey]);
        $data = [
            "username" => $user->username,
            "secret_name" => "example",
            "encrypted_secret" => $encryptedSecret . "COULD NOT BE DECRYPTED"
        ];

        $signature = $this->signRequest($user->username);
        $header = ["signature" => $signature];

        $response = $this->json('POST', 'api/encryption/storeSecret', $data, $header);

        $response
            ->assertStatus(400)
            ->assertJson(
                [
                    "success" => false,
                    "code" => 102,
                    "locale" => "en",
                    "message" => "Error #102",
                    "data" => [
                        "values" => [
                            "102" => "Could not decrypt data."
                        ]
                    ],
                    "debug" => []
                ]
            );
    }

    private function encryptDataWithServerKey(string $publicKey, string $plainText): string
    {
        $publicKey = PublicKey::fromString($publicKey);

        return base64_encode($publicKey->encrypt($plainText));
    }

    private function signRequest(string $username): string
    {
        $privateKey = file_get_contents('tests/user-private-key.pem');

        return PrivateKey::fromString($privateKey)->sign($username);
    }
}
