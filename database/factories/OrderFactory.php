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
                "value" => "/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAHgAoADASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD+H+iiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKK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LJqNlCDm5tbrWyDm3OPyxAIyA3TGfl9ScdT7nv3q5pl/f6PfWmpaZe3WnajptzbXllf2c0sF7Z3kUzzwXVlNB/pEM9tPDn7RnHTOTghxhFU5U1yuL+JWdpc85Sb5ZN25pXvq7uTcm76/hWSeP/F2VePFfx35VWzXH5/i80zbKViuXB4zIcVKrluM4V+tXxX+y4bJZSyzK8Xi8PiXljoYTGPCYrG4WSf0Z+0f+zn4m+Bni3UQlhc3PgS+uFbw3r4MstvJaSOfKsb64mlM0Ws7i8d7Z3CscKtxasdNEch+Zlz8yjgDb6HHL/nuyO/GfrX6kfCf/goBoeoaDH4R/aF8LHV4zHb203ijS9NsNQstShR9yP4j8LXT+SjKy5urrS2uGuGww0i2OCe5ur//AIJmeJ5/7dvpfDf2iZlYo6fFDSQsg+Rc6Tbtp8UWAoUWxtjtAUAkDJyourT92raULK0m588WmlHmbT53a7c5S57cl1KanN/r+e+EXgH4sYvMeL/CPxp4M8NIZlifrOaeHXilLDcH1chxWJxmL+sYPIc1eLlhsfhb64XL8to5jh8rwfLgp5rRqRw1Gl+VXgjwR4r+JHiSy8JeC9Gu9c1rUXCwWttGFEMSiQzXV5Mf3FlZW5H+lahc/wCjW52qAzHFfszcf8I3+w5+yzPpkd/HqPi68jvFt5LfENz4g8eatELefUIYpxPJBpnhyCOEC6IjRNO022GJL7UD5/B6r+2Z+zB8HdCudG+B/hH+3r3yisKaPolx4Y0aWaN7uSJ9W1jWrK31a6WB2Z2VNM1AFnZmvLdyzV+Y/wAWfjL4/wDjb4ml8TeONUjuZIhJFpGl2UUltpGhWZmMrWmnWpnujEBtH2qe7a5ubg7zd3lwzSE7L3oSWmyTSbsleXvc3KnzWs7+7ZOWsmrv2cr4i8HforZPxNieAuOcJ4t+OGe5Xishyvinh/K2+C/DjB4vDYb65i8qxmKxWY5dn+aPEf7rmuFeP9uqGDynF4TJsHiM5wmZ+aF2cu7szNIwd2Zj5jyZYDvx1P6c5NNoorY/hcKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA//2Q=="
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
            "review" => ["comment" => "هذا تعليق تجريبي", "rating" => 3.5],
            "cost" => "500 دينار",
            "GPS" => ["latitude" => 13.1, "longtitude" => 32.5],
        ];

        // to use the same offer in service factory and offer factory, it needs to be defined sperately
        // $offer = \App\Models\Offer::factory()->create();

        return [
            //
            'service_id' => \App\Models\Service::factory()->approved()->create()->id,
            // 'offer_id' => $offer->id,
            'user_id' => \App\Models\User::factory()->create()->id,
            'status' => 'done',
            'fields' => ($fields),
            'meta_data' => ($meta_data)
        ];
    }
}
