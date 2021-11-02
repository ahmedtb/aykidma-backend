<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $withparent = random_int(1, 5) == 5;
        return [
            'name' => $this->faker->word(),
            'image' => getBase64DefaultImage(),
            'parent_id' => ($withparent) ? (Category::inRandomOrder()->first() ?? Category::factory()->create()) : null
        ];
    }
}
