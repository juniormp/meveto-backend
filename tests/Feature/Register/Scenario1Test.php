<?php


namespace Tests\Feature\Register;


use App\Domain\Auth\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Helper\CleanString;
use Tests\TestCase;

class Scenario1Test extends TestCase
{
    use DatabaseMigrations;

    /*
     * User successfully register on application
     *
     * GIVEN the User on terminal
     * WHEN them request /register with username and public_key
     * THEN the User is registered on application
     */
    public function test_successfully_register()
    {
        $publicKey = file_get_contents('tests/user-public-key.pem');

        $data = [
            "username" => "mauricio",
            "public_key" => $publicKey
        ];

        $response = $this->json('POST', 'api/auth/register', $data);

        $response
            ->assertStatus(201)
            ->assertJson(
                [
                    "success" => true,
                    "code" => 0,
                    "locale" => "en",
                    "message" => "OK",
                    "data" => [
                        "username" => $data['username']
                    ]
                ]
            );

        $user = User::first();
        $this->assertDatabaseCount(User::class, 1);
        $this->assertEquals($data['username'], $user->username);
        $this->assertEquals(CleanString::clean($data['public_key']), CleanString::clean($user->key->public_key));
    }
}
