<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
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

        Order::factory()->count(10)->create();

    }

    public function test_check_all_orders_in_database()
    {


        $response = $this->getJson('api/orders');

        $size = sizeof($response->json());

        // $response->dump();
        $response
            ->assertJson(
                function (AssertableJson $json) use ($size) {
                    for ($x = 0; $x < $size; $x++) {
                        $json->has(
                            $x,
                            fn (AssertableJson $sample) =>
                            $sample->whereType('id', 'integer')
                                ->whereType('user_id', 'integer')
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

        $response = $this->getJson('api/orders/1');

        $size = sizeof($response->json());
        $response
            ->assertJson(
                function (AssertableJson $json) use ($size) {
                    for ($x = 0; $x < $size; $x++) {
                        $json->has(
                            $x,
                            fn (AssertableJson $sample) =>
                            $sample->whereType('id', 'integer')
                                ->whereType('service_id', 'integer')
                                ->whereType('user_id', 'integer')
                                ->whereType('status', 'string')
                                ->whereType('fields', 'array')
                                ->whereType('meta_data.location.name', 'string')
                                ->etc()
                        );
                    }
                }

            );
    }

    public function test_validating_a_valid_creating_order_request()
    {
        // testing valid request
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
        $response = $this->postJson('api/orders',[
            'service_id' => 1,
            'user_id' => 1,
            'fields' => $fields
        ]);


        $response->assertStatus(200);

    }

    public function test_validating_a_invalid_creating_order_request_without_requeird_field_properties()
    {
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
        $response = $this->postJson('api/orders',[
            'service_id' => 1,
            'user_id' => 1,
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
        $response = $this->postJson('api/orders',[
            'service_id' => 1,
            'user_id' => 1,
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
        $response = $this->postJson('api/orders',[
            // 'service_id' => 1,
            'user_id' => 1,
            'fields' => $fields
        ]);

        $response->assertStatus(422);

        $response = $this->postJson('api/orders',[
            'service_id' => 'string',
            'user_id' => 1,
            'fields' => $fields
        ]);

        $response->assertStatus(422);

        $response = $this->postJson('api/orders',[
            'service_id' => 1,
            'user_id' => 'invalid',
            'fields' => $fields
        ]);

        $response->assertStatus(422);
    }
}
