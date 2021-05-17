<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ExpoToken;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpoTokenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExpoToken::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'expo_token' => $this->faker->password(),
            'personal_access_token_id' => User::factory()->create()->createToken('mobile')->accessToken->id
        ];
    }
}
