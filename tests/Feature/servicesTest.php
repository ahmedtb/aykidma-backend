<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Category;
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


    public function test_user_can_can_fetch_all_services_guaranteed_that_they_have_a_correct_format()
    {
        Order::factory()->count(10)->create();
        $this->withoutExceptionHandling();

        $response = $this->getJson('api/services');

        // dd($response->json());

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
                                ->whereType('approved', 'boolean')
                                ->whereType('title', 'string')
                                ->whereType('description', 'string')
                                ->whereType('fields', 'array')
                                ->whereType('category_id', 'integer')
                                ->whereType('image', 'string')
                                ->whereType('meta_data','array')
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
        $service = Service::factory()->make();
        $response = $this->actingAs($provider,'web')->postJson('api/services', [
            // 'service_provider_id' => $provider->id,
            'title' => $service->title,
            'description' => $service->description,
            'fields' => $service->fields,
            'category_id' => $service->category_id,
            'image' =>  $service->image,
            'meta_data' => $service->meta_data,
        ])->assertStatus(201)->assertJson(['message' => 'service successfully created']);
    }

    // public function test_provider_will_create_offer_when_submit_request_to_create_service()
    // {
        
    //     $this->postJson('api/createServiceWithOffer', [])->assertUnauthorized();

    //     $provider = ServiceProvider::factory()->create();
    //     $category = Category::factory()->create();
    //     $offer = Offer::factory()->make(['category_id' => $category->id]);
        
    //     $this->actingAs($provider,'web')->postJson('api/createServiceWithOffer', [
    //         'title' => $offer->title,
    //         'description' => $offer->description,
    //         'fields' => $offer->fields,
    //         'category_id' => $offer->category_id,
    //         'meta_data' => $offer->meta_data,
    //         'details' => 'details about the services'
    //     ])->assertStatus(201);
    // }
    public function test_Provider_can_submit_requst_to_create_service_and_the_admins_can_accepting_it()
    {
        $service = Service::factory()->create();
        $admin = Admin::factory()->create();

        $this->putJson('api/approve/service', [
            'service_id' => $service->id
        ])->assertUnauthorized();

        // $this->withoutExceptionHandling();
        $this->actingAs($admin,'web')->putJson('api/approve/service', [
            'service_id' => $service->id
        ])->assertOK()->assertJson(['success' => 'the service has been approved']);

        $response = $this->actingAs($admin,'web')->putJson('api/approve/service', [
            'service_id' => $service->id
        ])->assertStatus(404);
        // dd($response->json());
        $response->assertJson(['failure' => 'the service is already approved']);
    }


    public function test_user_can_fetch_only_services_that_are_approved()
    {
        // $offer = Offer::factory()->create([]);

        Service::factory()->create();
        $response = $this->getJson('api/services');
        $this->assertEquals(sizeof($response->json() ), 0);

        Service::factory()->approved()->create();
        $response = $this->getJson('api/services');
        $this->assertEquals(sizeof($response->json() ), 1);


    }

    public function test_user_can_fetch_approved_services_with_category_id()
    {
        $service = Service::factory()->create();
        $response = $this->get('api/services/' . $service->category_id);
        $this->assertEquals(sizeof($response->json() ), 0);
        $response->assertStatus(200);

        $service = Service::factory()->approved()->create();
        $response = $this->get('api/services/' . $service->category_id);
        $this->assertEquals(sizeof($response->json() ), 1);
        $response->assertStatus(200);
    }
}
