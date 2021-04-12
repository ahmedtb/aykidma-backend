<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Order;

class ordersUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_check_all_orders_in_DB()
    {
        Order::all();

        // $response = $this->getJson('api/orders');

        // $size = sizeof($response->json());
        // $response
        //     ->assertJson(
        //         function (AssertableJson $json) use ($size) {
        //             for ($x = 0; $x < $size; $x++) {
        //                 $json->has(
        //                     $x,
        //                     fn (AssertableJson $sample) =>
        //                     $sample->whereType('id', 'integer')
        //                         ->whereType('service_id', 'integer')
        //                         ->whereType('user_id', 'integer')
        //                         ->whereType('status', 'string')
        //                         ->whereType('fields', 'array')
        //                         ->whereType('meta_data.location.name', 'string')
        //                         ->etc()
        //                 );
        //             }
        //         }

        //     );
    }
}
