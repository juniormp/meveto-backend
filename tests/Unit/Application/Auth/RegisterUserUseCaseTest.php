<?php


namespace Tests\Unit\Application\Auth;


use App\Application\Auth\Command\RegisterUserCommand;
use App\Application\Auth\RegisterUserUseCase;
use App\Domain\Auth\User;
use App\Domain\Auth\UserFactory;
use App\Domain\Encryption\Key;
use App\Domain\Encryption\KeyFactory;
use App\Infrastructure\Repository\Auth\UserRepository;
use App\Infrastructure\Repository\Encryption\KeyRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery;
use Tests\TestCase;

class RegisterUserUseCaseTest extends TestCase
{
    use DatabaseMigrations;

    public function test_register_user()
    {
        $userFactory = Mockery::mock(UserFactory::class);
        $userRepository = Mockery::mock(UserRepository::class);
        $keyFactory = Mockery::mock(KeyFactory::class);
        $keyRepository = Mockery::mock(KeyRepository::class);
        $command = new RegisterUserCommand(['username' => 'mau', 'public_key' => 'public_key']);
        $user = User::factory()->create();
        $key = Key::factory()->create(['user_id' => $user->id]);

        $userFactory->shouldReceive('create')->with($command)->andReturn($user)->once();
        $userRepository->shouldReceive('save')->with($user)->andReturn($user)->once();
        $keyFactory->shouldReceive('create')->with($user->id, $command->public_key)->andReturn($key)->once();
        $keyRepository->shouldReceive('save')->with($key)->once();

        $registerUser = new RegisterUserUseCase($userFactory, $userRepository, $keyFactory, $keyRepository);
        $response = $registerUser->execute($command);

        $this->assertEquals($user, $response);
    }
}
