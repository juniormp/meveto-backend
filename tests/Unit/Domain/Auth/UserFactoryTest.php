<?php


namespace Tests\Unit\Domain\Auth;


use App\Application\Auth\Command\RegisterUserCommand;
use App\Domain\Auth\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserFactoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_creates_user()
    {
        $userFactory = new UserFactory();
        $command = new RegisterUserCommand(['username' => 'mau', 'public_key' => 'public_key']);

        $user = $userFactory->create($command);

        $this->assertEquals($command->username, $user->username);
    }
}
