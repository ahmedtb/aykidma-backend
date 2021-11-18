<?php

namespace Tests\Feature;

use App\FieldsTypes\ArrayOfFields;
use App\FieldsTypes\ImageField;
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


class OrdersTest extends TestCase
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

        $response = $this->actingAs($user, 'user')->getJson('api/orders/1');

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

        $user = User::factory()->create();
        ServiceProvider::factory()->forUser($user)->create();
        $response = $this->actingAs($user, 'user')->postJson('api/orders', [
            'service_id' => $service->id,
            'array_of_fields' => $array_of_fields
        ]);

        // dd($response->json());
        $response->assertStatus(200);
    }

    public function test_auth_users_can_not_submit_orders_to_their_serivce_provider_acount_services()
    {
        $user = User::factory()->create();
        $provider = ServiceProvider::factory()->forUser($user)->create();
        $service = Service::factory()->forProvider($provider)->create();
        $array_of_fields = $service->array_of_fields;
        $array_of_fields->generateMockedValues();
        $response = $this->actingAs($user, 'user')->postJson('api/orders', [
            'service_id' => $service->id,
            'array_of_fields' => $array_of_fields
        ]);

        // dd($response->json());
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['user']);
    }

    public function test_order_fields_structure_should_have_valid_fields()
    {

        $service = Service::factory()->create();

        $user = User::factory()->create();
        $this->actingAs($user, 'user');

        // null values and not matching the service fields
        $array_of_fields = new ArrayOfFields([
            new StringField('aaaaaaa'),
            new StringField('aaaaaaa'),
        ]);
        $array_of_fields->generateMockedValues();
        $response = $this->postJson('api/orders', [
            'service_id' => $service->id,
            'array_of_fields' => $array_of_fields
        ]);
        $response->assertStatus(422);

        $array_of_fields = $service->array_of_fields;
        // matching the service fields but have null values
        $response = $this->postJson('api/orders', [
            'service_id' => $service->id,
            'array_of_fields' => $array_of_fields
        ]);
        $response->assertStatus(422);

        // matching the service fields but have values
        $array_of_fields->generateMockedValues();
        $user = User::factory()->create();
        $this->actingAs($user, 'user');
        $response = $this->postJson('api/orders', [
            'service_id' => $service->id,
            'array_of_fields' => $array_of_fields
        ]);
        $response->assertStatus(200);
    }

    public function test_auth_user_can_mark_his_resumed_orders_as_done()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id, 'status' => 'resumed']);

        $this->actingAs($user, 'user')->put('api/order/done', [
            'order_id' => $order->id
        ])->assertOk()->assertJson(['success' => 'order successfully marked as done']);
    }

    public function test_service_provider_can_resume_order_that_belong_to_his_services()
    {
        $service_provider = ServiceProvider::factory()->create();
        $service = Service::factory()->create(['service_provider_id' => $service_provider->id]);
        $order = Order::factory()->create([
            'service_id' => $service->id,
            'status' => 'new'
        ]);

        $response = $this->putJson('api/order/resume/', [
            'order_id' => $order->id
        ])->assertUnauthorized();
        // dd($response->json());
        $this->actingAs($service_provider->user, 'provider')->putJson('api/order/resume/', [
            'order_id' => 111
        ])->assertStatus(400);

        $this->actingAs($service_provider->user, 'provider')->putJson('api/order/resume/', [
            'order_id' => $order->id
        ])->assertOk();

        // $response->assertStatus(200);
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
        $response = $this->actingAs($provider->user, 'provider')->delete('api/providerOrder/' . $order->id)
            ->assertOk()->assertJson(['success' => 'order: ' . $order->id . ' successfully deleted']);
        // dd($response->json());

        $this->assertEquals(Order::all()->count(), 0);
    }

    public function test_provider_can_see_user_phone_number_who_make_order_to_his_service()
    {
    }

    public function test_service_phone_number_is_revealed_to_the_user_only_when_he_have_resumed_order_is_for_the_service()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'user');
        // service with new orders only
        $service = Service::factory()->create();
        $order = Order::factory(10)->create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'status' => 'new'
        ]);

        $response = $this->getJson('api/userOrders');
        $size = sizeof($response->json());

        for ($x = 0; $x < $size; $x++) {
            $this->assertArrayNotHasKey('phone_number', $response->json()[$x]['service']);
        }
        $response = $this->getJson('api/service/' . $service->id . '/PhoneNumber');
        $response->assertStatus(422);

        $user = User::factory()->create();
        $this->actingAs($user, 'user');

        // service with resumed orders only
        $service = Service::factory()->create();
        $order = Order::factory(10)->create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'status' => 'resumed'
        ]);
        $response = $this->getJson('api/userOrders');
        $size = sizeof($response->json());

        for ($x = 0; $x < $size; $x++) {
            $this->assertArrayHasKey('phone_number', $response->json()[$x]['service']);
        }


        $response = $this->getJson('api/service/' . $service->id . '/PhoneNumber');
        $response->assertStatus(200);

        $this->assertNotEmpty($response->content());
    }

    public function test_user_can_edit_his_new_order()
    {
    
    }
}
