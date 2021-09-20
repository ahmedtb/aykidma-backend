<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ServiceProviderTest extends TestCase
{
    use DatabaseMigrations;

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
        $this->actingAs($service_provider, 'provider')->putJson('api/order/resume/', [
            'order_id' => 111
        ])->assertStatus(400);

        $this->actingAs($service_provider, 'provider')->putJson('api/order/resume/', [
            'order_id' => $order->id
        ])->assertOk();

        // $response->assertStatus(200);
    }

    public function test_service_provider_can_retrive_his_services()
    {
        $service_provider = ServiceProvider::factory()->create();
        $services = Service::factory()->count(5)->create([
            'service_provider_id' => $service_provider->id,
            'meta_data' => []
        ]);

        $response = $this->actingAs($service_provider, 'provider')->getJson('api/myServices')->assertOk();
        // dd($response->json());
        $this->assertEquals(sizeof($response->json()), 5);
    }

    public function test_provider_can_retrive_his_orders()
    {
        $service_provider = ServiceProvider::factory()->create();
        $service = Service::factory()->create(['service_provider_id' => $service_provider->id]);
        Order::factory()->count(5)->create(['service_id' => $service->id]);
        $response = $this->actingAs($service_provider, 'provider')->getJson('api/providerOrders')->assertOk();

        $sample_index = random_int(0, sizeof($response->json()) - 1);

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(
                    $sample_index,
                    fn (AssertableJson $sample) =>
                    $sample->whereType('id', 'integer')
                        ->whereType('user_id', 'integer')
                        ->whereType('service_id', 'integer')
                        ->whereType('status', 'string')
                        ->whereType('fields', 'array')
                        ->has(
                            'fields.1',
                            fn ($json) =>
                            $json->whereType('label', 'string')
                                ->whereType('type', 'string')
                                ->has('value')
                                ->etc()
                        )
                        ->whereType('meta_data', 'array')
                        ->whereType('comment', 'string')
                        ->whereType('rating', 'integer')
                        ->whereType('cost', 'integer')
                        ->whereType('service', 'array')
                        ->whereType('created_at', 'string')
                        ->whereType('updated_at', 'string')
                        ->has('laravel_through_key')
                )
            );
    }
}
