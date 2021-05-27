<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Category;
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

        $fields = [
            [
                "titles" => [
                    "حي السلام",
                    "حي الزهور",
                    "عين زارة",
                    "سوق الخميس",
                    "حي الاندلس"
                ],
                "label" => "اختر المنطقة",
                "name" => "testingOptions",
                "type" => "options",
                "value" => null
            ],
            [
                "titles" => [
                    "سجاد",
                    "مفروشات",
                    "صالونات",
                    "جلسات",
                    "ستارات"
                ],
                "label" => "اختر نوع الغسيل",
                "name" => "testingOptions2",
                "type" => "options",
                "value" => null
            ],
            [
                "titles" => [
                    "اليوم",
                    "غدا",
                    "خلال اسبوع",
                    "الاسبوع القادم"
                ],
                "label" => "اختار الوقت المفضل للتنفيذ",
                "name" => "testingOptions3",
                "type" => "options",
                "value" => null
            ],
            [
                "label" => "أوصف مشكلتك وحاجتك بوضوح",
                "subLabel" => "أضف وصف واضح لمشكلتك، ليتمكن مزود الخدمة من فهمها وتقديم العرض الافضل لك",
                "name" => "testingTextArea",
                "type" => "textarea",
                "value" => null
            ],
            [
                "label" => "أضف صورة للمشكلة (اختياري)",
                "name" => "testingImage",
                "type" => "image",
                "value" => null
            ],
            // [
            //     "label" => "سيتم استخدام موقعك الحالي كدليل لتقديم الخدمة",
            //     "name" => "testingLocation",
            //     "type" => "location",
            //     "value" => [
            //         "latitude" => null,
            //         "longitude" => null
            //     ]
            // ]
        ];
        $meta_data = [
            "price" => "300 جنيه",
            "GPS" => ["latitude" => 13.1, "longtitude" => 32.5],
            "rating" => $this->faker->numberBetween(0, 5)
        ];
        return [
            "service_provider_id" => \App\Models\ServiceProvider::factory()->create()->id,
            // 'approved' => $this->faker->boolean(), // has a default value of false
            "title" => $this->faker->sentence(),
            'description' => $this->faker->randomHtml(),
            'fields' => $fields,
            'category_id' => Category::factory()->create(),
            'image'=> $this->faker->imageUrl(), // it has default value
            'meta_data' => $meta_data
        ];
    }

    /**
     * set the service as approved
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'approved' => true,
            ];
        });
    }
}
