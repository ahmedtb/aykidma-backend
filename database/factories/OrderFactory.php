<?php

namespace Database\Factories;

use App\Models\Order;
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
        $fields = [
            [
                "label" => "اختر المنطقة",
                "type" => "options",
                "value" => "حي السلام"
            ],
            [
                "label" => "اختر نوع الغسيل",
                "type" => "options",
                "value" => "مفروشات"
            ],
            [
                "label" => "اختار الوقت المفضل للتنفيذ",
                "type" => "options",
                "value" => "غدا"
            ],
            [
                "label" => "أوصف مشكلتك وحاجتك بوضوح",
                "type" => "textarea",
                "value" => "وصف عام للمشكلة"
            ],
            [
                "label" => "أضف صورة للمشكلة (اختياري)",
                "type" => "image",
                "value" => "here should be image uri"
            ],
            [
                "label" => "سيتم استخدام موقعك الحالي كدليل لتقديم الخدمة",
                "type" => "location",
                "value" => [
                    "latitude" => 13.2,
                    "longitude" => 32.5
                ]
            ]
        ];

        $meta_data = [
            "review" => ["comment" => "هذا تعليق مزور", "rating" => 3.5],
            "cost" => "500 دينار",
            "location" => [
                "GPS" => ["latitude" => 13.1, "longtitude" => 32.5],
                "name" => "طرابلس"
            ]
        ];

        // to use the same offer in service factory and offer factory, it needs to be defined sperately
        // $offer = \App\Models\Offer::factory()->create();
        return [
            //
            'service_id' => \App\Models\Service::factory()->create()->id,
            // 'offer_id' => $offer->id,
            'user_id' => \App\Models\User::factory()->create(),
            'status' => 'done',
            'fields' => ($fields),
            'meta_data' => ($meta_data)
        ];
    }
}
