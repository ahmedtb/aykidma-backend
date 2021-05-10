<?php

namespace Database\Factories;

use App\Models\Service;
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
        return [
            "service_provider_id" => \App\Models\ServiceProvider::factory()->create()->id,
            'offer_id' => \App\Models\Offer::factory()->create()->id,
            'approved' => false,
            // "meta_data" => [
            //     "cost" => "500 دينار",
            //     "location" => ["GPS" => ["latitude" => 13.1, "longtitude" => 32.5]],
            //     "details" => "<h1 style=\"text-align: center\">عروض التنظيف لشهر رمضان المبارك</h1>\n        <img src=\"https://static.seattletimes.com/wp-content/uploads/2018/11/cleaning_1111-780x520.jpg\" />\n        <p style=\"font-size:18;\">أقوي غسيل سجاد وكل المفروشات صالونات جلسات ستارات فرشات منادير صالونات...درجة أولي وبإحترافية عالية - مش كل من عنده ماكينة يعرف ينظف...</p>\n        <p style=\"font-size:18;\">خبرة سنوات طويلة في التنظيف أقوي معدات لشفط البقع العميقة لغسيل ونظافة وتجفيف السجاد في عين المكان</p>\n        <p style=\"font-size:18;\">مش ماكينة صابون وخلاص....نشفطوا الاوساخ (زيوت دهون سوائل...أي شي) من العمق الي السطح والنتيجة أنظف سجاد وريحة روعة من لاخير موكيت - بن وليد - عجمي - صيني - أي سجاد يحتاج الي عناية متخصصة</p>\n        <p style=\"font-size:18;\">تنظيفنا من الجذور لجميع المفروشات و أنواع السجاد وليس سطحي فقط غسيلنا عميق وعلي 3 مراحل - مفروشاتك و سجادك يصبح فعلا نظيف نظيف نظيف ثم التعطير بعطر شرقي او غربي </p>\n        <p style=\"font-size:18;\">فريق متخصص لغسيل المفروشات والسجاد لخدمتكم أين ماكنتم</p>\n        <p style=\"font-size:18;\">المساجد : سعر خاص للمساجد والعقود الثابتة والمساحات فوق 500م</p>\n        <p style=\"font-size:18;\">مفيش حاجة متتنظفش...ستائر جلسات صالونات سيارات...كله في مكانه",
            // ],
            "rating" => $this->faker->numberBetween(0,5)
        ];
    }
}
