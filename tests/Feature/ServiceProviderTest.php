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

        // $sample_index = random_int(0, sizeof($response->json()) - 1);
        // dd($response->json()[0]['array_of_fields']['fields'][1]);
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(
                    0,
                    fn (AssertableJson $sample) =>
                    $sample->whereType('id', 'integer')
                        ->whereType('user_id', 'integer')
                        ->whereType('service_id', 'integer')
                        ->whereType('status', 'string')
                        ->whereType('array_of_fields', 'array')
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
                        ->whereType('created_at', 'string')
                        ->whereType('updated_at', 'string')
                        ->has('laravel_through_key')
                )
            );
    }

    public function test_anyone_can_fetch_the_provider_profile_and_his_activated_services()
    {
        $service_provider = ServiceProvider::factory()->activated()->create();
        $services = Service::factory(15)->approved(false)->forProvider($service_provider)->create();
        $services = Service::factory(5)->approved(true)->forProvider($service_provider)->create();

        $response = $this->getJson('api/provider/' . $service_provider->id);
        // dd($response->json());
        $response->assertJsonStructure([
            'id',
            'name',
            'activated',
            'coverage' => ['*' => ['city', 'area']],
            'image',
            'meta_data'
        ]);
        $response = $this->getJson('api/provider/' . $service_provider->id . '/services');
        // dd($response->json());
        $response->assertJsonStructure([
            [
                'id',
                'title',
                'description',
                'array_of_fields' => [
                    'class',
                    'fields' => ['*' => ['class', 'value', 'required']]
                ],
                'approved',
                'category_id',
                'meta_data',
            ]
        ]);
        $response->assertJsonCount(5);
    }
}
