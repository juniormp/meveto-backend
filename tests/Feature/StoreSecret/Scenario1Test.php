<?php


namespace Tests\Feature\StoreSecret;


use App\Domain\Auth\User;
use App\Domain\Storage\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Crypto\Rsa\KeyPair;
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
        [$privateKey, $publicKey] = (new KeyPair())->generate();
        config(['PRIVATE_KEY' => $privateKey, 'PUBLIC_KEY' => $publicKey]);
        $this->assertEquals($privateKey, config('PRIVATE_KEY'));
        $this->assertEquals($publicKey, config('PUBLIC_KEY'));
        $plainText = 'text to be encrypt';

        $encryptedSecret = $this->encryptDataWithServerKey($publicKey, $plainText);

        $user = User::factory()->create(['username' => 'mauricio']);
        $data = [
            "username" => $user->username,
            "secret_name" => "example",
            "encrypted_secret" => $encryptedSecret
        ];

        $response = $this->json('POST', 'api/encryption/storeSecret', $data);

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
        $this->assertDatabaseCount( Storage::class, 1);
        $this->assertEquals($user->id, $storage->user->id);
        $this->assertEquals($data['secret_name'], $storage->secret_name);
        $this->assertEquals($data['encrypted_secret'], $storage->encrypted_secret);
    }

    private function encryptDataWithServerKey(string $publicKey, string $plainText): string
    {
        $publicKey = PublicKey::fromString($publicKey);

        return base64_encode($publicKey->encrypt($plainText));
    }
}
