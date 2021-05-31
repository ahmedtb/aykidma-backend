<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
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
        $category = Category::factory()->create();
        $this->assertNotEmpty($category->image);
    }

    public function test_admin_can_create_category_in_browser()
    {
        // $this->withoutExceptionHandling();
        $category = Category::factory()->make();

        $this->post('/category',[
            'name' => $category->name,
            'image' => $category->image,
            'parent_id' => $category->parent_id
        ])->assertRedirect();
    }

    public function test_admin_can_update_category_in_browser()
    {
        $this->withoutExceptionHandling();
        $category1 = Category::factory()->create();

        $category2 = Category::factory()->make();

        $this->put('/category/' . $category1->id,[
            'name' => $category2->name,
            'image' => $category2->image,
        ])->assertRedirect();
    }

    public function test_admin_can_create_category_with_api()
    {
        $this->withoutExceptionHandling();
        $category = Category::factory()->make();

        $this->post('api/category',[
            'name' => $category->name,
            'image' => $category->image,
            'parent_id' => $category->parent_id
        ])->assertOk()->assertJson(['success' => 'You have successfully created a Category!']);
    }

    public function test_admin_can_update_category_with_api()
    {
        $this->withoutExceptionHandling();
        $category1 = Category::factory()->create();

        $category2 = Category::factory()->make();

        $this->put('api/category/' . $category1->id,[
            'name' => $category2->name,
            'image' => $category2->image,
        ])->assertOk()->assertJson(['success' => 'You have successfully updated a Category!']);
    }

    public function test_drive_stored_image_file_should_be_deleted_when_deleting_the_category()
    {
        
    }
}
