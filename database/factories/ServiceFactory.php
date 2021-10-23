<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Category;
use App\FieldsTypes\StringField;
use App\FieldsTypes\ArrayOfFields;
use App\FieldsTypes\ImageField;
use App\FieldsTypes\LocationField;
use App\FieldsTypes\OptionsField;
use App\FieldsTypes\TextAreaField;
use App\Models\ServiceProvider;
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

        $meta_data = [
            "price" => "300 جنيه",
            "GPS" => ["latitude" => 13.1, "longtitude" => 32.5],
            "rating" => $this->faker->numberBetween(0, 5)
        ];
        return [
            "service_provider_id" => \App\Models\ServiceProvider::activated(true)->inRandomOrder()->first() ?? \App\Models\ServiceProvider::factory()->create(['activated' => true])->id,
            'approved' => $this->faker->boolean(),
            "title" => $this->faker->sentence(),
            'description' => $this->faker->text(),
            'array_of_fields' => $array_of_fields,
            'category_id' => Category::factory()->create(),
            'image' => getBase64DefaultImage(),
            'meta_data' => $meta_data,
            'price' => random_int(0, 65535),
            'phone_number' => $this->faker->phoneNumber(),

        ];
    }

    public function approved($bool = true)
    {
        return $this->state(function (array $attributes) use ($bool) {
            return [
                'approved' => $bool,
            ];
        });
    }

    public function forProvider(ServiceProvider $provider)
    {
        return $this->state(function (array $attributes) use($provider) {
            return [
                "service_provider_id" => $provider->id
            ];
        });
    }
}
