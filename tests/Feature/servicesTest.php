<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class servicesTest extends TestCase
{
    use DatabaseMigrations;


    protected function setUp(): void
    {

        parent::setup();

        Order::factory()->count(10)->create();
    }
    public function test_check_services_retrieved_by_offer_id()
    {
        $response = $this->getJson('api/service/1');

        $size = sizeof($response->json());
        $response
            ->assertJson(
                function (AssertableJson $json) use ($size) {
                    for ($x = 0; $x < $size; $x++) {
                        $json->has(
                            $x,
                            fn (AssertableJson $sample) =>
                            $sample->whereType('id', 'integer')
                                ->whereType('service_provider_id', 'integer')
                                ->whereType('offer_id', 'integer')
                                ->has('meta_data')
                                ->whereType('service_provider', 'array')
                                ->etc()
                        );
                    }
                }

            );
    }

    public function test_provider_can_submit_request_to_create_service()
    {
        $this->withoutExceptionHandling();
        $provider = ServiceProvider::factory()->create();
        $offer = Offer::factory()->create();
        $this->actingAs($provider)->postJson('api/services', [
            'service_provider_id' => $provider->id,
            'offer_id' => $offer->id,
            'meta_data' => ['details' => 'details about the services'],
        ])->assertStatus(201)->assertJson(['message' => 'service successfully created']);
    }

    public function test_provider_will_create_offer_when_submit_request_to_create_service()
    {
        $provider = ServiceProvider::factory()->create();
        $offer = Offer::factory()->make();

        $this->postJson('api/createServiceWithOffer', [
            'title' => $offer->title,
            'description' => $offer->description,
            'fields' => $offer->fields,
            'meta_data' => $offer->meta_data,
            'details' => 'details about the services'
        ])->assertUnauthorized();

        $this->actingAs($provider)->postJson('api/createServiceWithOffer', [
            'title' => $offer->title,
            'description' => $offer->description,
            'fields' => $offer->fields,
            'meta_data' => $offer->meta_data,
            'details' => 'details about the services'
        ])->assertStatus(201);
    }
    public function test_Provider_can_submit_requst_to_create_service_and_the_admins_can_accepting_it()
    {
        $service = Service::factory()->create();
        $admin = Admin::factory()->create();

        $this->putJson('api/approve/service', [
            'service_id' => $service->id
        ])->assertUnauthorized();

        // $this->withoutExceptionHandling();
        $this->actingAs($admin)->putJson('api/approve/service', [
            'service_id' => $service->id
        ])->assertOK()->assertJson(['success' => 'the service has been approved']);

        $response = $this->actingAs($admin)->putJson('api/approve/service', [
            'service_id' => $service->id
        ])->assertStatus(404);
        // dd($response->json());
        $response->assertJson(['failure' => 'the service is already approved']);
    }
}
