<?php

namespace Database\Factories;

use App\Models\ServiceProvider;
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
        $meta_data = [
            "description" => "هذا وصف اختباري",
            "location" => ["GPS" => ["latitude"=> 13.1, "longtitude"=> 32.5]]
        ];
        return [
            //
            "name" => $this->faker->name(),
            'phone_number' => $this->faker->phoneNumber,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            "image" => 'https://www.mintformations.co.uk/blog/wp-content/uploads/2020/05/shutterstock_583717939.jpg',
            "meta_data" => $meta_data
        ];
    }
}
