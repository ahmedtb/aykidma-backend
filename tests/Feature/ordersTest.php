<?php

namespace Tests\Feature;

use App\FieldsTypes\ArrayOfFields;
use App\FieldsTypes\StringField;
use Tests\TestCase;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Rules\Base64Rule;
use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ordersTest extends TestCase
{
    use DatabaseMigrations;

    public function test_all_orders_retrieved_from_database_came_in_a_correct_formate_json()
    {
        $user = User::factory()->create();
        Order::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'user')->getJson('api/userOrders');

        $size = sizeof($response->json());
        // dd($response->json());
        $response
            ->assertJson(
                function (AssertableJson $json) use ($size, $user) {
                    for ($x = 0; $x < $size; $x++) {
                        $json->has(
                            $x,
                            fn (AssertableJson $sample) =>
                            $sample->whereType('id', 'integer')
                                ->where('user_id', $user->id)
                                ->whereType('service_id', 'integer')
                                ->whereType('status', 'string')
                                ->whereType('array_of_fields.fields', 'array')
                                ->has(
                                    'array_of_fields.fields.1',
                                    fn ($json) =>
                                    $json->whereType('label', 'string')
                                        ->whereType('class', 'string')
                                        ->has('value')
                                        ->etc()
                                )
                                ->whereType('meta_data', 'array')
                                ->whereType('comment', 'string')
                                ->whereType('rating', 'integer')
                                ->whereType('cost', 'integer')
                                ->whereType('service', 'array')
                                ->whereType('service.service_provider', 'array')
                                ->whereType('created_at', 'string')
                                ->whereType('updated_at', 'string')
                        );
                    }
                }

            );
    }

    public function test_orders_can_be_retrived_by_service_id()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        Order::factory()->count(10)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'web')->getJson('api/orders/1');

        $size = sizeof($response->json());
        $response
            ->assertJson(
                function (AssertableJson $json) use ($size, $user) {
                    for ($x = 0; $x < $size; $x++) {
                        $json->has(
                            $x,
                            fn (AssertableJson $sample) =>
                            $sample->whereType('id', 'integer')
                                ->where('user_id', $user->id)
                                ->whereType('service_id', 'integer')
                                ->whereType('status', 'string')
                                ->whereType('array_of_fields', 'array')
                                ->whereType('meta_data', 'array')
                                ->whereType('comment', 'string')
                                ->whereType('rating', 'integer')
                                ->whereType('cost', 'integer')
                                ->whereType('service', 'array')
                                ->whereType('service.service_provider', 'array')
                                ->whereType('created_at', 'string')
                                ->whereType('updated_at', 'string')
                        );
                    }
                }

            );
    }



    public function test_only_authenticated_users_can_submit_orders()
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();
        $array_of_fields = $service->array_of_fields;

        // with values set to string
        $array_of_fields->generateMockedValues();
        // dd($array_of_fields);
        $response = $this->postJson('api/orders', [
            'service_id' => $service->id,
            'array_of_fields' => $array_of_fields
        ]);


        $response->assertUnauthorized();

        $response = $this->actingAs($user, 'user')->postJson('api/orders', [
            'service_id' => $service->id,
            'array_of_fields' => $array_of_fields
        ]);

        // dd($response->json());
        $response->assertStatus(200);
    }

    public function test_auth_users_can_not_submit_orders_to_their_serivce_provider_acount_services()
    {
    }

    public function test_validating_a_invalid_creating_order_request_without_requeird_field_properties()
    {
        $service = Service::factory()->create();

        $user = User::factory()->create();
        $this->actingAs($user, 'web');


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
        $this->actingAs($user, 'web');

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

    public function test_order_fields_structure_should_match_service_fields_structure()
    {
        $service = Service::factory()->create();
        $array_of_fields = $service->array_of_fields;
        // with values set to string
        // foreach ($array_of_fields as $key => $field) {
        //     $array_of_fields[$key]['value'] = "Some value";
        // }
        $array_of_fields->generateMockedValues();
        // dd($array_of_fields);
        $user = User::factory()->create();
        $this->actingAs($user, 'user');
        $response = $this->postJson('api/orders', [
            'service_id' => $service->id,
            'array_of_fields' => $array_of_fields
        ]);
        // dd($response->json());
        $response->assertStatus(200);


        // when array_of_fields does not match offer array_of_fields
        $array_of_fields = new ArrayOfFields([
            new StringField('random label', 'value')
        ]);
        // $this->withoutExceptionHandling();
        $response = $this->postJson('api/orders', [
            'service_id' =>  $service->id,
            'array_of_fields' => $array_of_fields
        ]);
        

        $response->assertStatus(422);
    }

    public function test_auth_user_can_mark_his_resumed_orders_as_done()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id, 'status' => 'resumed']);

        $this->actingAs($user, 'web')->put('api/order/done', [
            'order_id' => $order->id
        ])->assertOk()->assertJson(['success' => 'order successfully marked as done']);
    }

    public function test_order_image_field_should_be_validated_as_base64_and_stored_as_linked_public_file_with_it_is_path_put_in_DB()
    {
    }

    public function test_user_admin_or_provider_can_delete_his_orders()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'user')->delete('api/userOrder/' . $order->id)
            ->assertOk()->assertJson(['success' => 'order: ' . $order->id . ' successfully deleted']);

        $admin = Admin::factory()->create();
        $order = Order::factory()->create();

        $response = $this->actingAs($admin, 'admin')->delete('api/order/' . $order->id)
            ->assertOk()->assertJson(['success' => 'order: ' . $order->id . ' successfully deleted']);

        $order = Order::factory()->create();
        $provider = $order->service->ServiceProvider;
        $response = $this->actingAs($provider, 'provider')->delete('api/providerOrder/' . $order->id)
            ->assertOk()->assertJson(['success' => 'order: ' . $order->id . ' successfully deleted']);
        // dd($response->json());

        $this->assertEquals(Order::all()->count(), 0);
    }
}
