<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ordersTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {

        parent::setup();
    }



    public function test_all_orders_retrieved_from_database_in_correct_formate_json()
    {
        $user = User::factory()->create();
        Order::factory()->count(10)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user,'web')->getJson('api/orders');

        $size = sizeof($response->json());

        // $response->dump();
        $response
            ->assertJson(
                function (AssertableJson $json) use ($size,$user) {
                    for ($x = 0; $x < $size; $x++) {
                        $json->has(
                            $x,
                            fn (AssertableJson $sample) =>
                            $sample->whereType('id', 'integer')
                                ->where('user_id', $user->id)
                                ->whereType('service_id', 'integer')
                                ->whereType('status', 'string')
                                ->whereType('fields', 'array')
                                ->whereType('meta_data.location.name', 'string')
                                ->etc()
                        );
                    }
                }

            );
    }

    public function test_check_orders_retrived_by_service_id()
    {

        $user = User::factory()->create();
        Order::factory()->count(10)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user,'web')->getJson('api/orders/1');

        $size = sizeof($response->json());
        $response
            ->assertJson(
                function (AssertableJson $json) use ($size,$user) {
                    for ($x = 0; $x < $size; $x++) {
                        $json->has(
                            $x,
                            fn (AssertableJson $sample) =>
                            $sample->whereType('id', 'integer')
                                ->whereType('service_id', 'integer')
                                ->where('user_id', $user->id)
                                ->whereType('status', 'string')
                                ->whereType('fields', 'array')
                                ->whereType('meta_data.location.name', 'string')
                                ->etc()
                        );
                    }
                }

            );
    }

    public function test_only_authenticated_user_can_retrive_orders()
    {
        $user = User::factory()->create();
        Order::factory()->count(10)->create(['user_id' => $user->id]);


        $response = $this->getJson('api/orders');
        $response->assertUnauthorized();

        $response = $this->getJson('api/orders/1');
        $response->assertUnauthorized();

        $this->actingAs($user,'web');

        $response = $this->getJson('api/orders');
        $response->assertOk();

        $response = $this->getJson('api/orders/1');
        $response->assertOk();
    }

    public function test_only_authenticated_users_can_submit_orders()
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();
        $fields = $service->offer->fields;

        // with values set to string
        foreach ($fields as $key => $field) {
            $fields[$key]['value'] = "Some value";
        }

        $response = $this->postJson('api/orders', [
            'service_id' => $service->id,
            'user_id' => 1,
            'fields' => $fields
        ]);


        $response->assertUnauthorized();

        $response = $this->actingAs($user,'web')->postJson('api/orders', [
            'service_id' => $service->id,
            'user_id' => 1,
            'fields' => $fields
        ]);


        $response->assertStatus(200);
    }

    public function test_validating_a_valid_creating_order_request()
    {

        $service = Service::factory()->create();
        $fields = $service->offer->fields;

        // with values set to string
        foreach ($fields as $key => $field) {
            $fields[$key]['value'] = "Some value";
        }
        
        $user = User::factory()->create();
        $this->actingAs($user,'web');

        $response = $this->postJson('api/orders', [
            'service_id' => $service->id,

            'fields' => $fields
        ]);


        $response->assertStatus(200);
    }

    public function test_validating_a_invalid_creating_order_request_without_requeird_field_properties()
    {
        $service = Service::factory()->create();

        $user = User::factory()->create();
        $this->actingAs($user,'web');


        $fields = [
            [
                "label" => "اختر المنطقة",
                "type" => "options",
                // "value" => "حي السلام"
            ],
            [
                "label" => "اختر نوع الغسيل",
                "type" => "options",
                "value" => "مفروشات"
            ],
        ];
        $response = $this->postJson('api/orders', [
            'service_id' => $service->id,

            'fields' => $fields
        ]);

        $response->assertStatus(422);

        $fields = [
            [
                "label" => "اختر المنطقة",
                "type" => "options",
                "value" => "حي السلام"
            ],
            [
                "label" => "اختر نوع الغسيل",
                // "type" => "options",
                "value" => "مفروشات"
            ],
        ];
        $response = $this->postJson('api/orders', [
            'service_id' => $service->id,

            'fields' => $fields
        ]);

        $response->assertStatus(422);

        $fields = [
            [
                "label" => "اختر المنطقة",
                "type" => "options",
                "value" => null
            ],
            [
                "label" => "اختر نوع الغسيل",
                "type" => "options",
                "value" => null
            ],
        ];
        $response = $this->postJson('api/orders', [
            'service_id' => $service->id,
            'fields' => $fields
        ]);

        $response->assertStatus(422);
    }

    public function test_validating_a_invalid_creating_order_request_without__valid_service_id_or_user_id()
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
        ];
        $response = $this->postJson('api/orders', [
            'service_id' => 1,
            'fields' => $fields
        ]);
        $response->assertUnauthorized();

        $user = User::factory()->create();
        $this->actingAs($user,'web');

        $response = $this->postJson('api/orders', [
            // 'service_id' => 1,
            'fields' => $fields
        ]);
        $response->assertStatus(422);

        $response = $this->postJson('api/orders', [
            'service_id' => 'string',
            'fields' => $fields
        ]);
        $response->assertStatus(422);

        $response = $this->postJson('api/orders', [
            'service_id' => 1,
            'fields' => $fields
        ]);
        $response->assertStatus(422);
    }

    public function test_order_fields_structure_should_match_offer_fields_structure()
    {
        $service = Service::factory()->create();
        $offer = $service->offer;
        $fields = $offer->fields;
        // with values set to string
        foreach ($fields as $key => $field) {
            $fields[$key]['value'] = "Some value";
        }

        $user = User::factory()->create();
        $this->actingAs($user,'web');

        $response = $this->postJson('api/orders', [
            'service_id' => $service->id,
            'fields' => $fields
        ]);

        $response->assertStatus(200);


        // when fields does not match offer fields
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
            ]
        ];

        $response = $this->postJson('api/orders', [
            'service_id' =>  $service->id,
            'fields' => $fields
        ]);

        $response->assertStatus(422);
    }
}
