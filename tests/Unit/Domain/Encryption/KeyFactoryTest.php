<?php


namespace Tests\Unit\Domain\Encryption;


use App\Domain\Encryption\KeyFactory;
use Tests\TestCase;

class KeyFactoryTest extends TestCase
{
    public function test_creates_key()
    {
        $keyFactory = new KeyFactory();

        $key = $keyFactory->create('1', 'public_key');

        $this->assertEquals(1, $key->user_id);
        $this->assertEquals('public_key', $key->public_key);
    }
}
