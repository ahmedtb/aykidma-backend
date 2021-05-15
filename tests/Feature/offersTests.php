<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Service;
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


    }

    public function test_retriveAllOffers()
    {
        Service::factory()->count(10)->create(['approved'=>true]);

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


    public function test_user_can_fetch_only_offers_with_approved_services()
    {
        $offer = Offer::factory()->create([]);

        Service::factory()->create(['approved'=>false, 'offer_id'=>$offer->id]);
        $response = $this->getJson('api/offers');
        $this->assertEquals(sizeof($response->json() ), 0);

        Service::factory()->create(['approved'=>true, 'offer_id'=>$offer->id]);
        $response = $this->getJson('api/offers');
        $this->assertEquals(sizeof($response->json() ), 1);


    }

    public function test_user_can_fetch_approved_services_only_offers_with_category_id()
    {
        $offer = Offer::factory()->create([]);

        Service::factory()->create(['approved'=>false, 'offer_id'=>$offer->id]);
        $response = $this->get('api/offers/' . $offer->category_id);
        $this->assertEquals(sizeof($response->json() ), 0);
        $response->assertStatus(200);

        Service::factory()->create(['approved'=>true, 'offer_id'=>$offer->id]);
        $response = $this->get('api/offers/' . $offer->category_id);
        $this->assertEquals(sizeof($response->json() ), 1);
        $response->assertStatus(200);
    }
}
