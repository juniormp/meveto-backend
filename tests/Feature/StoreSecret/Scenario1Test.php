<?php


namespace Tests\Feature\StoreSecret;


use App\Domain\Auth\User;
use App\Domain\Encryption\Key;
use App\Domain\Storage\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;
use Tests\TestCase;

class Scenario1Test extends TestCase
{
    use DatabaseMigrations;

    /*
     * User successfully store secret on application
     *
     * GIVEN the User on terminal
     * WHEN them request /storeSecret with username, secret_name and encrypted_secret.
     * THEN the secret is stored on application
     */
    public function test_successfully_store_secret()
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
            "encrypted_secret" => $encryptedSecret
        ];

        $signature = $this->signRequest($user->username);
        $header = ["signature" => $signature];

        $response = $this->json('POST', 'api/encryption/storeSecret', $data, $header);

        $response
            ->assertStatus(201)
            ->assertJson(
                [
                    "success" => true,
                    "code" => 0,
                    "locale" => "en",
                    "message" => "OK",
                    "data" => null
                ]
            );

        $storage = Storage::first();
        $this->assertDatabaseCount(Storage::class, 1);
        $this->assertEquals($user->id, $storage->user->id);
        $this->assertEquals($data['secret_name'], $storage->secret_name);
        $this->assertEquals($data['encrypted_secret'], $storage->encrypted_secret);
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
