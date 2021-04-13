<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
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
                                ->whereType('meta_data.details', 'string')
                                ->whereType('service_provider', 'array')
                                ->etc()
                        );
                    }
                }

            );
    }
}
