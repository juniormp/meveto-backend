<?php

namespace Database\Factories\Domain\Storage;

use App\Domain\Auth\User;
use App\Domain\Storage\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

class StorageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Storage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'secret_name' => $this->faker->name(),
            'encrypted_secret' => $this->faker->text()
        ];
    }
}
