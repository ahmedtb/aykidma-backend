<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_fetch_all_parent_categories()
    {
        $response = $this->get('api/category');

        $response->assertStatus(200);
    }

    public function test_category_should_have_an_image()
    {
        
    }
}
