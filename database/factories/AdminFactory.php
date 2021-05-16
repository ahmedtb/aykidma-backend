<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

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
        $image = 'https://www.mintformations.co.uk/blog/wp-content/uploads/2020/05/shutterstock_583717939.jpg';
        $meta_data = [
            "description" => $this->faker->sentence(),
            // "policy" => "admin"
        ];
        return [
            "name" => $this->faker->name(),
            'phone_number' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'password' => Hash::make('password'),
            'address' =>  $address,
            "image" => $image,
            "meta_data" => $meta_data
        ];
    }
}
