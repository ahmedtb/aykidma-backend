<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ServicesTest extends TestCase
{
    use DatabaseMigrations;


    public function test_user_can_can_fetch_all_services_guaranteed_that_they_have_a_correct_format()
    {
        Order::factory()->count(10)->create();
        $this->withoutExceptionHandling();

        $response = $this->getJson('api/services');

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
                                ->whereType('array_of_fields', 'array')
                                ->whereType('category_id', 'integer')
                                ->whereType('image', 'string')
                                ->whereType('meta_data', 'array')
                                ->whereType('price', 'integer')
                                ->whereType('created_at', 'string')
                                ->whereType('updated_at', 'string')->etc()
                        );
                    }
                }
            );
        // dd($response->json());

    }

    public function test_provider_can_submit_request_to_create_service()
    {
        $provider = ServiceProvider::factory()->create();
        $service = Service::factory()->make();
        $response = $this->actingAs($provider->user, 'provider')->postJson('api/services', [
            'title' => $service->title,
            'description' => $service->description,
            'array_of_fields' => $service->array_of_fields,
            'category_id' => $service->category_id,
            'image' =>  $service->image,
            'meta_data' => $service->meta_data,
            'phone_number' => $service->phone_number
        ])->assertStatus(201)->assertJson(['message' => 'service successfully created']);
        $firstService = $provider->Services()->first();
        $this->assertTrue($firstService->title == $service->title);
        $this->assertTrue($firstService->description == $service->description);
        $this->assertTrue($firstService->array_of_fields == $service->array_of_fields);
        $this->assertTrue($firstService->category_id == $service->category_id);
        $this->assertTrue($firstService->image == $service->image);
        $this->assertTrue($firstService->meta_data == $service->meta_data);
        $this->assertTrue($firstService->phone_number == $service->phone_number);

        $this->assertNotNull($provider->Services()->first());
    }

    public function test_if_service_create_request_contain_null_image_input_the_system_should_put_default_image()
    {
        $provider = ServiceProvider::factory()->create();
        $service = Service::factory()->make();
        $response = $this->actingAs($provider->user, 'provider')->postJson('api/services', [
            'title' => $service->title,
            'description' => $service->description,
            'array_of_fields' => $service->array_of_fields,
            'category_id' => $service->category_id,
            // 'image' =>  $service->image,
            'meta_data' => $service->meta_data,
        ]);
        $this->assertTrue($provider->Services()->first()->image != null);
    }

    public function test_Provider_can_submit_requst_to_create_service_and_the_admins_can_accepting_it()
    {
        $service = Service::factory()->create();
        $admin = Admin::factory()->create();

        $this->putJson('approve/service', [
            'service_id' => $service->id
        ])->assertUnauthorized();

        $this->withoutExceptionHandling();
        $this->actingAs($admin, 'admin')->putJson('approve/service', [
            'service_id' => $service->id
        ])->assertOK()->assertJson(['success' => 'the service has been approved']);

        $response = $this->actingAs($admin, 'admin')->putJson('approve/service', [
            'service_id' => $service->id
        ])->assertStatus(404);
        // dd($response->json());
        $response->assertJson(['failure' => 'the service is already approved']);
    }


    public function test_user_can_fetch_only_services_that_are_approved()
    {
        // $offer = Offer::factory()->create([]);

        Service::factory()->approved(false)->create();
        $response = $this->getJson('api/services');
        // dd($response->json());
        $this->assertEquals(sizeof($response->json()), 0);

        Service::factory()->approved()->create();
        $response = $this->getJson('api/services');
        // dd($response->json());
        $this->assertEquals(sizeof($response->json()), 1);
    }

    public function test_user_can_fetch_approved_services_with_category_id()
    {
        $service = Service::factory()->approved(false)->create();
        $response = $this->get('api/services/' . $service->category_id);
        $this->assertEquals(sizeof($response->json()), 0);
        $response->assertStatus(200);

        $service = Service::factory()->approved()->create();
        $response = $this->get('api/services/' . $service->category_id);
        $this->assertEquals(sizeof($response->json()), 1);
        $response->assertStatus(200);
    }

    public function test_provider_can_edit_his_service_weather_it_is_approved_or_not()
    {
        $updateTo = Service::factory()->make();
        $service = Service::factory()->create();

        $response = $this->actingAs($service->ServiceProvider, 'provider')->putJson('api/services/' . $service->id, [
            'title' => $updateTo->title,
            'description' => $updateTo->description,
            'fields' => $updateTo->fields,
            'category_id' => $updateTo->category_id,
            'image' => $updateTo->image,
            'meta_data' =>  $updateTo->meta_data,
        ])->assertStatus(200);
    }

    public function test_user_can_fetch_service_reviews()
    {
        $service = Service::factory()->approved()->create();
        $orders = Order::factory(10)->create([
            'service_id' => $service->id
        ]);
        $reviews = Review::factory(10)->create();
        // dd($service->orders()->with('user')->select(['user'])->get());

        $response = $this->getJson('api/service/' . $service->id . '/reviews');
        // dd($response->json());
        $response->assertOk();
        $response->assertJsonCount(10);
        $response->assertJsonStructure(['*' => ['comment', 'rating', 'user' => ['name']]]);

        $response = $this->getJson('api/services');
        // dd($response->json()[0]['reviews']);
    }
}
