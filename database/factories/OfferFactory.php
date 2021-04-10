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

        $fake_offer_version = random_int(1, 10);

        switch ($fake_offer_version) {

            case 1:
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
                    "price" => "500 جنيه",
                    "location" => ["GPS" => ["latitude" => 13.1, "longtitude" => 32.5]],
                    "image" => 'https://www.end-of-tenancy-london.co.uk/wp-content/uploads/2018/02/car-interior-cleaning.jpg?x53702'
                ];

                return [
                    "title"=> "غسيل صالونات السيارات",
                    "description" => "<h1 style=\"text-align: center\">غسيل صالونات السيارات</h1>\n        <img src=\"https://www.end-of-tenancy-london.co.uk/wp-content/uploads/2018/02/car-interior-cleaning.jpg?x53702\" />\n        <p style=\"font-size:18;\">إزالة البقع والترسبات وأثار العرق والروائح الكريهة من العمق</p>\n        <p style=\"font-size:18;\">• أرضية وكراسى فقط + (تلميع فودرة وأبواب مجانا)</p>\n        <p style=\"font-size:18;\">كركوبة-------- 120د (بيكانتو, وماشابه)</p>\n        \n        <p style=\"font-size:18;\">عادية --------- 140د ( سيراتو, فيرنا, أكسنت, أزيرا, وماشابه)</p>\n        \n        <p style=\"font-size:18;\">عالية صفتين كراسى ----160 د ( سانتافي, سبورتاج, وماشابه)</p>\n        <p style=\"font-size:18;\">عالية 3 صفات كراسى --- 180د (سانتافي, جيب, بي أم, مرسيدس, وماشابه)</p>\n        <p style=\"font-size:18;\">عالية كبيرة ------ 220د ( مفخرة, لبوة, جى أم سي, وماشابه)</p>\n        \n        <p style=\"font-size:18;\">• كاملة ( أرضية وكراسى سقف) + (تلميع فودرة وأبواب وكوفيني خلفي مجانآ)</p>\n        <p style=\"font-size:18;\">كركوبة-------- 150د (بيكانتو, وماشابه)</p>\n        <p style=\"font-size:18;\">عادية --------- 180د ( سيراتو, فيرنا, أكسنت, أزيرا, وماشابه)</p>\n        <p style=\"font-size:18;\">عالية صفتين كراسى --- 200 د ( سانتافي, سبورتاج, وماشابه)</p>\n        <p style=\"font-size:18;\">عالية 3 صفات كراسى --- 220د (سانتافي, جيب, بي أم, مرسيدس, وماشابه)</p>\n        <p style=\"font-size:18;\">عالية كبيرة ------ 250د ( مفخرة, لبوة, جى أم سي, وماشابه)</p>\n        \n        <p style=\"font-size:18;\">*ملاحظة: لو سيارتك حالتها سيئة.. يعني فيها بقع صعبة وإتساخ زايد تحتاج خدمة إضافية, فيه تكلفة إضافية بسيطة يحددها الفني لما يجيك.</p>\n        <p style=\"font-size:18;\">للحجز الان:</p>\n        0918510100\n        0928510100",
                    'fields' => ($fields),
                    'meta_data' => ($meta_data)
                ];

            case 2:
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
                    "price" => "300 جنيه",
                    "location" => ["GPS" => ["latitude" => 13.1, "longtitude" => 32.5]],
                    "image" => 'https://static.seattletimes.com/wp-content/uploads/2018/11/cleaning_1111-780x520.jpg'
                ];

                return [
                    "title" => "عروض التنظيف لشهر رمضان المبارك",
                    "description" => "<h1 style=\"text-align: center\">عروض التنظيف لشهر رمضان المبارك</h1>\n        <img src=\"https://static.seattletimes.com/wp-content/uploads/2018/11/cleaning_1111-780x520.jpg\" />\n        <p style=\"font-size:18;\">أقوي غسيل سجاد وكل المفروشات صالونات جلسات ستارات فرشات منادير صالونات...درجة أولي وبإحترافية عالية - مش كل من عنده ماكينة يعرف ينظف...</p>\n        <p style=\"font-size:18;\">خبرة سنوات طويلة في التنظيف أقوي معدات لشفط البقع العميقة لغسيل ونظافة وتجفيف السجاد في عين المكان</p>\n        <p style=\"font-size:18;\">مش ماكينة صابون وخلاص....نشفطوا الاوساخ (زيوت دهون سوائل...أي شي) من العمق الي السطح والنتيجة أنظف سجاد وريحة روعة من لاخير موكيت - بن وليد - عجمي - صيني - أي سجاد يحتاج الي عناية متخصصة</p>\n        <p style=\"font-size:18;\">تنظيفنا من الجذور لجميع المفروشات و أنواع السجاد وليس سطحي فقط غسيلنا عميق وعلي 3 مراحل - مفروشاتك و سجادك يصبح فعلا نظيف نظيف نظيف ثم التعطير بعطر شرقي او غربي </p>\n        <p style=\"font-size:18;\">فريق متخصص لغسيل المفروشات والسجاد لخدمتكم أين ماكنتم</p>\n        <p style=\"font-size:18;\">المساجد : سعر خاص للمساجد والعقود الثابتة والمساحات فوق 500م</p>\n        <p style=\"font-size:18;\">مفيش حاجة متتنظفش...ستائر جلسات صالونات سيارات...كله في مكانه</p>",
                    'fields' => ($fields),
                    'meta_data' => ($meta_data)
                ];

            case 3:
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
                    "price" => "300 جنيه",
                    "location" => ["GPS" => ["latitude" => 13.1, "longtitude" => 32.5]],
                    "image" => "https://scontent.fmji1-1.fna.fbcdn.net/v/t1.0-9/162401705_1168100206969525_4678605220874723277_n.jpg?_nc_cat=101&ccb=1-3&_nc_sid=9267fe&_nc_ohc=YNHgciJmL6wAX9RRyIY&_nc_ht=scontent.fmji1-1.fna&oh=87a0570264a6a12bf73300ac46a8169f&oe=607BAC98",
                ];

                return [
                    "title"=> "سيارة نقل بورتر حافظة لنقل اغرضكم الشخصية",
                    "description" => "<h1 style=\"text-align: center\">سيارة نقل بورتر حافظة لنقل اغرضكم الشخصية</h1>\n        <img src=\"https://scontent.fmji1-1.fna.fbcdn.net/v/t1.0-9/162401705_1168100206969525_4678605220874723277_n.jpg?_nc_cat=101&ccb=1-3&_nc_sid=9267fe&_nc_ohc=YNHgciJmL6wAX9RRyIY&_nc_ht=scontent.fmji1-1.fna&oh=87a0570264a6a12bf73300ac46a8169f&oe=607BAC98\" />\n        <p style=\"font-size:18;\">نوفر لك فني فك وتركيب الاثاث واعمال صيانة متنوعة</p>\n    \n        <p style=\"font-size:18;\">الاسعار من 50د وتزيد حسب الاغراض</p>\n    \n        <p style=\"font-size:18;\">مثلا: صيانة أثاث - تركيب أقفال أبواب - تعديل تركيب الخدمات المنزلية البسيطة- سباكة - كهرباء - اي شي يبي خدمة في المنزل</p>\n    \n        <p style=\"font-size:18;\">للتواصل من 9 - 5 يوميا فقط</p>\n    \n        <p style=\"font-size:18;\">\"أي خدمة\" الشركة الوحيدة في طرابلس توفر لككم فنيين خبرة في كل المجالات</p>\n    \n        <p style=\"font-size:18;\">- راحة وأمان .. جودة و ضمان...</p>\n    \n        <p style=\"font-size:18;\">0918510100</p>\n        <p style=\"font-size:18;\">0928510100</p>",
                    'fields' => ($fields),
                    'meta_data' => ($meta_data)
                ];

            case 4:
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
                    "price" => "250 جنيه",
                    "location" => ["GPS" => ["latitude" => 13.1, "longtitude" => 32.5]],
                    "image" => "https://scontent.fmji1-1.fna.fbcdn.net/v/t1.0-9/161046382_777648833127560_8437564257839968440_n.jpg?_nc_cat=104&ccb=1-3&_nc_sid=825194&_nc_ohc=UHo9dO0aUjMAX_WPcw8&_nc_ht=scontent.fmji1-1.fna&oh=a4288bd2fe56a74e44e0850c1b83193d&oe=607C328C",
                ];

                return [
                    "title" => "خدمات طلاء",
                    "description" => "<h1 style=\"text-align: center\">خدمات طلاء</h1>\n        <img src=\"https://scontent.fmji1-1.fna.fbcdn.net/v/t1.0-9/161046382_777648833127560_8437564257839968440_n.jpg?_nc_cat=104&ccb=1-3&_nc_sid=825194&_nc_ohc=UHo9dO0aUjMAX_WPcw8&_nc_ht=scontent.fmji1-1.fna&oh=a4288bd2fe56a74e44e0850c1b83193d&oe=607C328C\" />\n        أقوي وأسرع وأضمن خدمات طلاء متوفرة مباني وعمارات وشقق..فنيين ليبيين ومصريين خبرة\n    \n    خدماتتنا أي نوع طلاء نخدموه لك\n    \n    - أعمال بضمان النتيجة وخبرتنا فنيينا أكثر من 15 سنة بإشراف علي كامل العمل والعمال\n    - التنفيذ سريع بعدة فرق جاهزة لاأي عدد للشقق والمباني الكبيرة والعمارات\n    - أعمالنا بإحترافية تنفيذ وتعامل راقي وتصحيح أي عيوب والتسليم علي مستوي %100\n    \n    *معاينة العمل قبل العمل والاتفاق واضح من البداية\n    \n    ملاحظة: يتوفر لدينا خدمة الجرافيت والسليكات والتكست ميديا أكثر من 200 لون متوفر\n    \n    للتواصل:\n    0917510100\n    0927510100",
                    'fields' => ($fields),
                    'meta_data' => ($meta_data)
                ];

            case 5:
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
                    "price" => "100 جنيه",
                    "location" => ["GPS" => ["latitude" => 13.1, "longtitude" => 32.5]],
                    "image" => "https://scontent.fmji1-1.fna.fbcdn.net/v/t1.0-9/159316826_1162178994228313_7413538856658560435_n.jpg?_nc_cat=104&ccb=1-3&_nc_sid=9267fe&_nc_ohc=6Zflkfk_HloAX91xR2o&_nc_ht=scontent.fmji1-1.fna&oh=da01d63b4c89e03a9f7fcbfdfa3eaf59&oe=607D5B41",
                ];

                return [
                    "title" => "تجديد وترميم الحمامات والمطابخ",
                    "description" => "<h1 style=\"text-align: center\">تجديد وترميم الحمامات والمطابخ</h1>\n        <img src=\"https://scontent.fmji1-1.fna.fbcdn.net/v/t1.0-9/159316826_1162178994228313_7413538856658560435_n.jpg?_nc_cat=104&ccb=1-3&_nc_sid=9267fe&_nc_ohc=6Zflkfk_HloAX91xR2o&_nc_ht=scontent.fmji1-1.fna&oh=da01d63b4c89e03a9f7fcbfdfa3eaf59&oe=607D5B41\" />\n        أروع تجديد وترميم الحمامات والمطابخ..\n        نقوم بالتكسير ونقل المخلفات وتنخدم السباكة بالكامل والكهرباء ثم الارضيات والحوائط\n        \n        خدمتنا يد عاملة فقط ونوفر تصميم تام شوف حمامك قبل مانخدموه...\n        مدة العمل عادة 10 ايام\n        السداد كاش وعلي دفعات مقدما.\n        \n        أي إستفسار اخر تفضل\n        0917510100\n        0927510100",
                    'fields' => ($fields),
                    'meta_data' => ($meta_data)
                ];

            case 6:
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
                    "price" => "1000 جنيه",
                    "location" => ["GPS" => ["latitude" => 13.1, "longtitude" => 32.5]],
                    "image" => "https://cache-landingpages-images.services.handy.com/2018/10/30/03/35/42/c0565f0f-d9b9-4273-87be-c1890dd997f9/woman-cleaning-oven-in-kitchen-closeup-picture-id942141666.jpg",
                ];

                return [
                    "title" => "صيانة وتنظيف وتجديد أفران الغاز والكهربائية",
                    "description" => "<h1 style=\"text-align: center\">صيانة وتنظيف وتجديد أفران الغاز والكهربائية</h1>\n        <img src=\"https://cache-landingpages-images.services.handy.com/2018/10/30/03/35/42/c0565f0f-d9b9-4273-87be-c1890dd997f9/woman-cleaning-oven-in-kitchen-closeup-picture-id942141666.jpg\" />\n        صيانة وتنظيف وتجديد أفران الغاز والكهربائية منازل مطاعم مقاهي فنادة بإحترافية عالية - فني خبرة 10سنوات\n       \"أي خدمة\" توفر لكم خدمات صيانة الافران المنزلية الكهربائية والغاز وانت في مكانك نجوك لعندك\n      ::::: صيانة * تنظيف * تجديد ::::::\n      خدماتنا :\n      - تصليح ألافران كهربائية و غاز\n      - توفير بعض قطع الغيار\n      - تفيير المرشة المكسورة\n      - تبديل المفاتيح المكسورة والمفقودة\n      - تنظيف وتجديد الافران بالمواد الخاصة تولي شبه جديدة\n      \n      قريبا..!!!خدمات تنظيف بالبخار  غاز ثلاجة مكيفات مركزي وعادي غسالات مجففات مطابخ وحمامات ومفروشات البيت كلها بالبخار وانت في مكانك نجوك لعندك\n      \n      الكشف مجاني في حالة تمت الصيانة  أو  50د الكشف فقط\n      نجوك لعندك\n      \"أي خدمة\" لجميع أعمال الصيانة والتركيب والتشطيب والتنظيف\n      أظف رقمنا الان:::\"أي خدمة\"::::::::\n      0918510100\n      0928510100\n      للمزيد من خدماتنا:  زوروا متجر \"أي خدمة\" علي السوق المفتوح أو زوروا صفحاتنا علي الفيس بوك ",
                    'fields' => ($fields),
                    'meta_data' => ($meta_data)
                ];

            default:
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
                    "price" => "300 جنيه",
                    "location" => ["GPS" => ["latitude" => 13.1, "longtitude" => 32.5]],
                    "image" => "https://scontent.fmji1-1.fna.fbcdn.net/v/t1.0-9/161046382_777648833127560_8437564257839968440_n.jpg?_nc_cat=104&ccb=1-3&_nc_sid=825194&_nc_ohc=UHo9dO0aUjMAX_WPcw8&_nc_ht=scontent.fmji1-1.fna&oh=a4288bd2fe56a74e44e0850c1b83193d&oe=607C328C",
                ];

                return [
                    "title" => $this->faker->sentence(),
                    "description" => "<h1 style=\"text-align: center\">خدمات طلاء</h1>\n        <img src=\"https://scontent.fmji1-1.fna.fbcdn.net/v/t1.0-9/161046382_777648833127560_8437564257839968440_n.jpg?_nc_cat=104&ccb=1-3&_nc_sid=825194&_nc_ohc=UHo9dO0aUjMAX_WPcw8&_nc_ht=scontent.fmji1-1.fna&oh=a4288bd2fe56a74e44e0850c1b83193d&oe=607C328C\" />\n        أقوي وأسرع وأضمن خدمات طلاء متوفرة مباني وعمارات وشقق..فنيين ليبيين ومصريين خبرة\n    \n    خدماتتنا أي نوع طلاء نخدموه لك\n    \n    - أعمال بضمان النتيجة وخبرتنا فنيينا أكثر من 15 سنة بإشراف علي كامل العمل والعمال\n    - التنفيذ سريع بعدة فرق جاهزة لاأي عدد للشقق والمباني الكبيرة والعمارات\n    - أعمالنا بإحترافية تنفيذ وتعامل راقي وتصحيح أي عيوب والتسليم علي مستوي %100\n    \n    *معاينة العمل قبل العمل والاتفاق واضح من البداية\n    \n    ملاحظة: يتوفر لدينا خدمة الجرافيت والسليكات والتكست ميديا أكثر من 200 لون متوفر\n    \n    للتواصل:\n    0917510100\n    0927510100",
                    'fields' => ($fields),
                    'meta_data' => ($meta_data)
                ];
        }
    }
}
