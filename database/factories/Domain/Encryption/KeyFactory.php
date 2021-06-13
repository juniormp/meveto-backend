<?php

namespace Database\Factories\Domain\Encryption;

use App\Domain\Encryption\Key;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Key::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'public_key' => $this->faker->text()
        ];
    }
}
