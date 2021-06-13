<?php


namespace Tests\Feature\GetServerKey;


use Spatie\Crypto\Rsa\KeyPair;
use Tests\TestCase;

class Scenario1Test extends TestCase
{
    /*
     * User successfully retrieves server public key
     *
     * GIVEN the User on terminal
     * WHEN them request /getServerKey
     * THEN retrieves server public key
     */
    public function test_successfully_retrieves_server_public_key()
    {
        [$privateKey, $publicKey] = (new KeyPair())->generate();
        config(['PUBLIC_KEY' => $publicKey]);
        $this->assertEquals($publicKey, config('PUBLIC_KEY'));

        $response = $this->json('GET', 'api/encryption/getServerKey');

        $response
            ->assertStatus(200)
            ->assertJson(
                [
                    "success" => true,
                    "code" => 0,
                    "locale" => "en",
                    "message" => "OK",
                    "data" => [
                        "value" => $publicKey
                    ]
                ]
            );
    }
}
