<?php


namespace Tests\Unit\Domain\Storage;


use App\Domain\Auth\User;
use App\Domain\Storage\StorageFactory;
use App\Infrastructure\Service\EncryptionHandlerService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery;
use Tests\TestCase;

class StorageFactoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_creates_storage()
    {
        $encryptionHandlerService = Mockery::mock(EncryptionHandlerService::class);
        $user = User::factory()->create();
        $storageFactory = new StorageFactory($encryptionHandlerService);

        $encryptedSecret = 'encrypted-secret';
        $secretName = 'app_test';
        $encryptionHandlerService->shouldReceive('canDecryptWithServerKey')
            ->with($encryptedSecret)->andReturn($encryptedSecret);

        $storage = $storageFactory->create($user, $secretName, $encryptedSecret);

        $this->assertEquals($user->id, $storage->user_id);
        $this->assertEquals($secretName, $storage->secret_name);
        $this->assertEquals($encryptedSecret, $storage->encrypted_secret);
    }
}
