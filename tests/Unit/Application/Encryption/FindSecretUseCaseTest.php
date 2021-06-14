<?php


namespace Tests\Unit\Application\Encryption;


use App\Application\Encryption\Command\FindSecretCommand;
use App\Application\Encryption\FindSecretUseCase;
use App\Domain\Auth\User;
use App\Domain\Storage\Storage;
use App\Infrastructure\Repository\Auth\UserRepository;
use App\Infrastructure\Repository\Storage\StorageRepository;
use App\Infrastructure\Service\EncryptionHandlerService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery;
use Tests\TestCase;

class FindSecretUseCaseTest extends TestCase
{
    use DatabaseMigrations;

    public function test_finds_secret()
    {
        $encryptionHandlerService = Mockery::mock(EncryptionHandlerService::class);
        $storageRepository = Mockery::mock(StorageRepository::class);
        $userRepository = Mockery::mock(UserRepository::class);
        $command = new FindSecretCommand(['username' => 'mau', 'secret_name' => 'secret_name']);
        $user = User::factory()->create();
        $storage = Storage::factory()->create(['user_id' => $user->id]);
        $encryptSecret = 'encryptSecret';

        $storageRepository->shouldReceive('findSecretByName')->with($command->secretName)
            ->andReturn($storage)->once();
        $userRepository->shouldReceive('findByUsername')->with($command->username)
            ->andReturn($user)->once();
        $encryptionHandlerService->shouldReceive('decryptWithServerKeyAndEncryptWithUserKey')
            ->with($user, $storage)->andReturn($encryptSecret);

        $findSecret = new FindSecretUseCase($encryptionHandlerService, $storageRepository, $userRepository);
        $response = $findSecret->execute($command);

        $this->assertEquals($encryptSecret, $response);
    }
}
