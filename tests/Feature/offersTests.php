<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Offer;
use App\Models\Order;
use App\Models\ServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class offersTests extends TestCase
{
    use DatabaseMigrations;


    protected function setUp(): void
    {

        parent::setup();

        Order::factory()->count(10)->create();

    }

    public function test_retriveAllOffers()
    {
        $response = $this->getJson('api/offers');

        // get random sample from response array to assert on
        $sample_index = random_int(0,sizeof($response->json()) - 1);

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(
                    $sample_index,
                    fn (AssertableJson $sample) =>
                    $sample->has('id')
                        ->whereType('id','integer')
                        ->has('title')
                        ->has('description')
                        ->whereType('fields','array')
                        ->has('meta_data.image')
                        ->etc()
                )
            );
    }

    public function test_provider_can_create_offer_when_creating_a_service()
    {
        $provider = ServiceProvider::factory()->create();
        $offer = Offer::factory()->make();

        $this->postJson('api/offers',[
            'title' => $offer->title,
            'description' => $offer->description,
            'fields' => $offer->fields,
            'meta_data' => $offer->meta_data,
            'details' => 'details about the services'
        ])->assertUnauthorized();

        $this->actingAs($provider)->postJson('api/offers',[
            'title' => $offer->title,
            'description' => $offer->description,
            'fields' => $offer->fields,
            'meta_data' => $offer->meta_data,
            'details' => 'details about the services'
        ])->assertStatus(201);
    }
}
