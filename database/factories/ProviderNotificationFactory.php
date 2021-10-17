<?php

namespace Database\Factories;

use App\Models\ProviderNotification;
use App\Models\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderNotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProviderNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'body' => $this->faker->sentence(),
            'type' => $this->faker->word(),
            'service_provider_id' => ServiceProvider::activated(true)->inRandomOrder()->first() ?? ServiceProvider::factory()->create()->id
        ];
    }
}
