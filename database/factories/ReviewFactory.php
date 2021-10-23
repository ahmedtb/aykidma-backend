<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // pick random unique order
        return [
            'user_id' => User::inRandomOrder()->first() ?? User::factory()->create()->id,
            'order_id' =>  Order::inRandomOrder()->where('status', 'done')->first()->id ?? Order::factory()->create()->id,
            'comment' => $this->faker->sentence(),
            'rating' => random_int(0, 5),
        ];
    }
}
