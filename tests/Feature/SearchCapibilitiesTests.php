<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Service;
use App\Models\Category;
use App\Models\ServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchCapibilitiesTests extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_search_through_the_services()
    {
        // no services in DB
        $this->getJson('api/search/services/searchTerm')->assertOk()->assertJsonCount(0);

        // two services in DB
        Service::factory(2)->create([
            'title' => 'searchTerm title'
        ]);
        $this->getJson('api/search/services/searchTerm')->assertOk()->assertJsonCount(2);
    }


    public function test_user_can_search_through_the_services_in_a_specific_category()
    {

        Service::factory(3)->create([
            'title' => 'searchTerm title'
        ]);
        $category = Category::factory()->create();
        Service::factory(2)->create([
            'title' => 'searchTerm title',
            'category_id' => $category->id
        ]);
        $this->getJson('api/search/services/' . $category->id . '/searchTerm')->assertOk()->assertJsonCount(2);
    }

    public function test_provider_can_search_through_his_new_orders()
    {
        $this->withoutExceptionHandling();
        $provider = ServiceProvider::factory()->create();
        $service = Service::factory()->create([
            'title' => 'searchTerm title',
            'service_provider_id' => $provider->id
        ]);
        // orders that does not belong to the service we search through it is title
        Order::factory(8)->create([
            'status' => 'new'
        ]);
        Order::factory(2)->create([
            'status' => 'new',
            'service_id' => $service->id
        ]);

        $this->actingAs($provider, 'provider')->getJson('api/provider/search/newOrders/searchTerm')
            ->assertOk()
            ->assertJsonCount(2);
    }

    public function test_provider_can_search_through_his_resumed_orders()
    {
        $this->withoutExceptionHandling();
        $provider = ServiceProvider::factory()->create();
        $service = Service::factory()->create([
            'title' => 'searchTerm title',
            'service_provider_id' => $provider->id
        ]);
        Order::factory(8)->create([
            'status' => 'done',
            'service_id' => $service->id
        ]);
        Order::factory(2)->create([
            'status' => 'resumed',
            'service_id' => $service->id
        ]);

        $this->actingAs($provider, 'provider')->getJson('api/provider/search/resumedOrders/searchTerm')
            ->assertOk()
            ->assertJsonCount(2);
    }

    public function test_provider_can_search_through_his_done_orders()
    {
        $this->withoutExceptionHandling();
        $provider = ServiceProvider::factory()->create();
        $service = Service::factory()->create([
            'title' => 'searchTerm title',
            'service_provider_id' => $provider->id
        ]);
        Order::factory(8)->create([
            'status' => 'new',
            'service_id' => $service->id
        ]);
        Order::factory(2)->create([
            'status' => 'done',
            'service_id' => $service->id
        ]);

        $this->actingAs($provider, 'provider')->getJson('api/provider/search/doneOrders/searchTerm')
            ->assertOk()
            ->assertJsonCount(2);
    }
}
