<?php

namespace Database\Factories;

use App\Models\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceProvider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $address = [
            'city' => 'tripoli',
            'area' => 'area1',
            'subArea' => 'subArea1'
        ];
        $coverage = [
            [
                'city' => 'tripoli',
                'area' => 'area1',
            ],
            [
                'city' => 'benghazi',
                'area' => 'area2',
            ],
            [
                'city' => 'misrata',
                'area' => 'area1',
            ]
        ];
        $meta_data = [
            "description" => "هذا وصف اختباري",
            "GPS" => ["latitude" => 13.1, "longtitude" => 32.5]
        ];

        return [
            //
            "name" => $this->faker->company(),
            "user_id" => User::inRandomOrder()->first() ?? User::factory()->create(),
            'activated' => $this->faker->boolean(),
            // 'phone_number' => $this->faker->phoneNumber(),
            // 'email' => $this->faker->email(),
            // 'password' => Hash::make('password'),
            // 'address' =>  $address,
            'coverage' => $coverage,
            "image" => getBase64DefaultImage(),
            "meta_data" => $meta_data
        ];
    }

    public function activated()
    {
        return $this->state(function (array $attributes) {
            return [
                'activated' => true,
            ];
        });
    }

    public function forUser(User $user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                "user_id" => $user->id,
            ];
        });
    }
    public function newUser()
    {
        return $this->state(function (array $attributes) {
            return [
                "user_id" => User::factory()->create(),
            ];
        });
    }
}
