<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class offersTests extends TestCase
{
    
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
}
