<?php


namespace Tests\Feature\GetServerKey;


use Tests\TestCase;

class Scenario2Test extends TestCase
{
    /*
     * User successfully retrieves null if server public key does not exist
     *
     * GIVEN the User on terminal
     * WHEN them request /getServerKey
     * THEN retrieves null
     */
    public function test_successfully_retrieves_nullable()
    {
        putenv("PUBLIC_KEY=null");

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
                        "public_key" => null
                    ]
                ]
            );
    }
}
