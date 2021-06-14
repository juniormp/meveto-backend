<?php


namespace Tests\Unit\Application\Encryption;


use App\Application\Encryption\Command\StoreSecretDataCommand;
use App\Application\Encryption\StoreSecretDataUseCase;
use App\Domain\Auth\User;
use App\Domain\Storage\Storage;
use App\Domain\Storage\StorageFactory;
use App\Infrastructure\Repository\Auth\UserRepository;
use App\Infrastructure\Repository\Storage\StorageRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery;
use Tests\TestCase;

class StoreSecretDataUseCaseTest extends TestCase
{
    use DatabaseMigrations;

    public function test_stores_secret_data()
    {
        $userRepository = Mockery::mock(UserRepository::class);
        $storageFactory = Mockery::mock(StorageFactory::class);
        $storageRepository = Mockery::spy(StorageRepository::class);
        $command = new StoreSecretDataCommand([
            'username' => 'mau',
            'secret_name' => 'secret_name',
            'encrypted_secret' => 'encrypted_secret'
        ]);
        $user = User::factory()->create();
        $storage = Storage::factory()->create(['user_id' => $user->id]);

        $userRepository->shouldReceive('findByUsername')->with($command->username)->andReturn($user)->once();
        $storageFactory->shouldReceive('create')->with($user, $command->secretName, $command->encryptedSecret)
            ->andReturn($storage)->once();

        $storeSecretData = new StoreSecretDataUseCase($userRepository, $storageFactory, $storageRepository);
        $storeSecretData->execute($command);

        $storageRepository->shouldHaveReceived('save')->with($storage)->once();
    }
}
