<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "service_provider_id" => \App\Models\ServiceProvider::factory()->create(),
            'offer_id' => \App\Models\Offer::factory()->create(),
            "meta_data" => json_encode([
                "cost" => "500 دينار",
                "location" => ["GPS" => ["latitude" => 13.1, "longtitude" => 32.5]]
            ]),
            "rating" => $this->faker->numberBetween(0,5)
        ];
    }
}
