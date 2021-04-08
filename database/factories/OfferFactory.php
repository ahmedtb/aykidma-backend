<?php

namespace Database\Factories;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offer::class;

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
            [
                "label" => "سيتم استخدام موقعك الحالي كدليل لتقديم الخدمة",
                "name" => "testingLocation",
                "type" => "location",
                "value" => [
                    "latitude" => null,
                    "longitude" => null
                ]
            ]
        ];

        $meta_data = [
            "price"=> "300 جنيه",
            "location" => ["GPS" => ["latitude" => 13.1, "longtitude" => 32.5]]
        ];

        return [
            "title" => $this->faker->sentence(),
            "description" => "<h1 style=\"text-align: center\">عروض التنظيف لشهر رمضان المبارك</h1>\n        <img src=\"https://static.seattletimes.com/wp-content/uploads/2018/11/cleaning_1111-780x520.jpg\" />\n        <p style=\"font-size:18;\">أقوي غسيل سجاد وكل المفروشات صالونات جلسات ستارات فرشات منادير صالونات...درجة أولي وبإحترافية عالية - مش كل من عنده ماكينة يعرف ينظف...</p>\n        <p style=\"font-size:18;\">خبرة سنوات طويلة في التنظيف أقوي معدات لشفط البقع العميقة لغسيل ونظافة وتجفيف السجاد في عين المكان</p>\n        <p style=\"font-size:18;\">مش ماكينة صابون وخلاص....نشفطوا الاوساخ (زيوت دهون سوائل...أي شي) من العمق الي السطح والنتيجة أنظف سجاد وريحة روعة من لاخير موكيت - بن وليد - عجمي - صيني - أي سجاد يحتاج الي عناية متخصصة</p>\n        <p style=\"font-size:18;\">تنظيفنا من الجذور لجميع المفروشات و أنواع السجاد وليس سطحي فقط غسيلنا عميق وعلي 3 مراحل - مفروشاتك و سجادك يصبح فعلا نظيف نظيف نظيف ثم التعطير بعطر شرقي او غربي </p>\n        <p style=\"font-size:18;\">فريق متخصص لغسيل المفروشات والسجاد لخدمتكم أين ماكنتم</p>\n        <p style=\"font-size:18;\">المساجد : سعر خاص للمساجد والعقود الثابتة والمساحات فوق 500م</p>\n        <p style=\"font-size:18;\">مفيش حاجة متتنظفش...ستائر جلسات صالونات سيارات...كله في مكانه</p>",
            'fields' => json_encode($fields),
            'meta_data' => json_encode($meta_data)
        ];
    }
}
