<?php

namespace Tests\Feature;

use App\Models\Admin;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use Database\Factories\AdminFactory;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class commentsTests extends TestCase
{
    use RefreshDatabase;
    public function test_orders_could_have_a_review_column()
    {
        $order = Order::factory()->withReview()->create();
        $this->assertNotEmpty($order->comment);
        $this->assertNotEmpty($order->comment);
    }

    public function test_user_can_review_on_his_order_that_is_done()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id, 'status' => 'resumed']);

        $response = $this->actingAs($user, 'web')->putJson('api/order/done', [
            'order_id' => $order->id,
            'comment' => Str::random(10),
            'rating' => random_int(0, 5)
        ])->assertOk()->assertJson(['success' => 'order successfully marked as done']);
        // dd($response->json());
        $this->assertNotNull($order->refresh()->comment);
        $this->assertNotNull($order->refresh()->rating);
    }

    public function test_user_can_edit_his_review()
    {
        $user = User::factory()->create();
        $order = Order::factory()->withReview()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'web')->putJson('api/order/editReview', [
            'order_id' => $order->id,
            'comment' => Str::random(10),
            'rating' => random_int(0, 5)
        ])->assertOk()->assertJson(['success' => 'review edited']);

        $this->assertNotNull($order->refresh()->comment);
        $this->assertNotNull($order->refresh()->rating);
    }

    public function test_review_data_should_come_with_the_order_that_is_done()
    {
        $user = User::factory()->create();
        $order = Order::factory()->withReview()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'user')
            ->getJson('api/userOrders')
            ->assertOk();
        // dd($response->json());
        $size = sizeof($response->json());

        $response->assertJson(
            function (AssertableJson $json) use ($size) {
                for ($x = 0; $x < $size; $x++) {
                    $json->has(
                        $x,
                        fn (AssertableJson $sample) =>
                        $sample->whereType('id', 'integer')
                            ->whereType('comment', 'string')
                            ->whereType('rating', 'integer')
                            ->etc()
                    );
                }
            }
        );
    }

    public function test_service_reviews_and_average_rating_could_be_fetched_on_demand()
    {
        $service = Service::factory()->create();
        $order = Order::factory(10)->withReview()->create(['service_id' => $service->id]);
        $this->assertNotEmpty($service->reviews());
        $this->assertEquals($service->reviews()->count(), 10);
    }

    public function test_fetched_service_details_should_contain_a_sample_of_the_best_and_the_worst_review()
    {
    }

    public function test_user_or_provider_could_report_about_a_review()
    {
    }

    public function test_admin_can_fetch_all_reports()
    {
    }

    public function test_admin_could_delete_inappropriete_review()
    {
        // $this->withoutExceptionHandling();
        $admin = Admin::factory()->create();
        $order = Order::factory()->withReview()->create();
        $response = $this->actingAs($admin, 'admin')->delete('/order/deleteReview', [
            'order_id' => $order->id
        ])->assertOk()->assertJson(['success' => 'review deleted']);
        // dd($response->content());
    }
}
