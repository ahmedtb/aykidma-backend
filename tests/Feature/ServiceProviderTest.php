<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ServiceProviderTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_service_provider_can_resume_order_that_belong_to_his_services()
    {
        $user = User::factory()->create();
        $service_provider = ServiceProvider::factory()->create();
        $service = Service::factory()->create(['service_provider_id' => $service_provider->id]);
        $order = Order::factory()->create(['user_id' => $user->id, 'service_id' => $service->id ]);
        
        $this->patchJson('api/order/resume/' ,[
            'order_id' => $order->id
        ])->assertUnauthorized();

        $this->actingAs($service_provider)->patchJson('api/order/resume/',[
            'order_id' => $order->id
        ])->assertOk();

        // $response->assertStatus(200);
    }
}
