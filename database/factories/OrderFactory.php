<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use App\FieldsTypes\ImageField;
use App\FieldsTypes\StringField;
use App\FieldsTypes\OptionsField;
use App\FieldsTypes\ArrayOfFields;
use App\FieldsTypes\LocationField;
use App\FieldsTypes\TextAreaField;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $array_of_fields =  new ArrayOfFields(array(
            new StringField('String Field label'),
            new TextAreaField('Text Field label'),
            new OptionsField(
                'Options Field label',
                array(
                    'option1',
                    'option2',
                    'option3',
                )
            ),
            new LocationField('location field'),
            new ImageField('image fields')
        ));
        $array_of_fields->generateMockedValues();

        $meta_data = [
            "GPS" => ["latitude" => 13.1, "longtitude" => 32.5],
        ];
        $states = array("new", "resumed", "done");

        return [
            //
            'service_id' => \App\Models\Service::approved()->inRandomOrder()->first() ??  \App\Models\Service::factory()->approved()->create()->id,
            'user_id' => \App\Models\User::inRandomOrder()->first() ?? \App\Models\User::factory()->create()->id,
            'status' => $states[array_rand($states)],
            'array_of_fields' => ($array_of_fields),
            'cost' => random_int(0, 65535),
            'meta_data' => $meta_data
        ];
    }
    // public function withReview()
    // {
    //     return $this->state(function (array $attributes) {
    //         return [
    //             'status' => 'done',
    //             'comment' => $this->faker->sentence(),
    //             'rating' => random_int(0, 5),
    //         ];
    //     });
    // }
}
