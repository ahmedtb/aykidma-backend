<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class ordersTest extends TestCase
{

    public function test_check_all_orders_in_database()
    {
        $response = $this->getJson('api/orders');

        $size = sizeof($response->json());
        $response
            ->assertJson(
                function (AssertableJson $json) use ($size) {
                    for ($x = 0; $x < $size; $x++) {
                        $json->has(
                            $x,
                            fn (AssertableJson $sample) =>
                            $sample->whereType('id', 'integer')
                                ->whereType('service_id', 'integer')
                                ->whereType('user_id', 'integer')
                                ->whereType('status', 'string')
                                ->whereType('fields', 'array')
                                ->whereType('meta_data.location.name', 'string')
                                ->etc()
                        );
                    }
                }

            );
    }

    public function test_check_orders_retrived_by_service_id() 
    {
        $response = $this->getJson('api/orders/1');

        $size = sizeof($response->json());
        $response
            ->assertJson(
                function (AssertableJson $json) use ($size) {
                    for ($x = 0; $x < $size; $x++) {
                        $json->has(
                            $x,
                            fn (AssertableJson $sample) =>
                            $sample->whereType('id', 'integer')
                                ->whereType('service_id', 'integer')
                                ->whereType('user_id', 'integer')
                                ->whereType('status', 'string')
                                ->whereType('fields', 'array')
                                ->whereType('meta_data.location.name', 'string')
                                ->etc()
                        );
                    }
                }

            );
    }
}
