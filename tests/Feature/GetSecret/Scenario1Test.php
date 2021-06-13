<?php


namespace Tests\Feature\GetSecret;


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
     * User successfully retrieves secret data
     *
     * GIVEN the User on terminal
     * WHEN them request /getSecret with username and secret_name
     * THEN retrieves data encrypt with User public key
     */
    public function test_successfully_retrieves_secret_data()
    {
        $userPrivateKey = file_get_contents('tests/user-private-key.pem');
        $userPublicKey = file_get_contents('tests/user-public-key.pem');

        $plainData = "FAKE-DATA";
        $encryptedSecret = $this->encryptSecretWithServerKey($plainData);

        $user = User::factory()->create(['username' => 'mau']);
        Key::factory()->create(['user_id' => $user->id, 'public_key' => $userPublicKey]);
        $storage = Storage::factory()->create([
            'user_id' => $user->id,
            'secret_name' => 'APP_FAKE',
            'encrypted_secret' => $encryptedSecret
        ]);

        $data = "$user->username&secret_name=$storage->secret_name";

        $signature = $this->signRequest($user->username);
        $header = ["signature" => $signature];

        $response = $this->json('GET', "api/encryption/getSecret?username=$data", [], $header);

        $response->assertStatus(200);

        $encryptedData = json_decode($response->getContent(), true)['data']['encrypted_secret'];
        $plainText = $this->decryptSecretWithUserPrivateKey($userPrivateKey, $encryptedData);
        $this->assertEquals($plainData, $plainText);
    }

    private function encryptSecretWithServerKey(string $plainText): string
    {
        $publicKey = file_get_contents('tests/app-public-key.pem');
        putenv("PUBLIC_KEY=$publicKey");

        $privateKey = file_get_contents('tests/app-private-key.pem');
        putenv("PRIVATE_KEY=$privateKey");

        $publicKey = PublicKey::fromString($publicKey);

        return base64_encode($publicKey->encrypt($plainText));
    }

    private function decryptSecretWithUserPrivateKey(string $userPrivateKey, string $encryptedData): string
    {
        $privateKey = PrivateKey::fromString($userPrivateKey);

        return $privateKey->decrypt(base64_decode($encryptedData));
    }

    private function signRequest(string $username): string
    {
        $privateKey = file_get_contents('tests/user-private-key.pem');

        return PrivateKey::fromString($privateKey)->sign($username);
    }
}
