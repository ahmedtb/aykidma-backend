<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserNotificationsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_fetch_his_notifications()
    {
        UserNotification::factory()->create();
        $user = User::factory()->create();
        UserNotification::factory(2)->create(['user_id' => $user->id]);
        $response = $this->actingAs($user,'web')->get('api/userNotifications');

        $response->assertStatus(200);
    }

    public function test_user_can_be_notified()
    {
        $user = User::factory()->create();
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
