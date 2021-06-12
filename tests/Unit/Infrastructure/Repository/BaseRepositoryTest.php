<?php


namespace Tests\Unit\Infrastructure\Repository;

use App\Domain\Auth\User;
use App\Infrastructure\Repository\BaseRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BaseRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_saves_model()
    {
        $baseRepository = new BaseRepository(User::class);
        $user = User::factory()->make();

        $baseRepository->save($user);
        $this->assertDatabaseCount($user->getTable(), 1);
    }
}
