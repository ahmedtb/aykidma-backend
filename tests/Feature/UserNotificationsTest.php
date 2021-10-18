<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use Mockery\MockInterface;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Notifications\MessageNotification;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\PersonalAccessToken;

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
        $this->actingAs($user, 'user');

        $response = $this->get('api/userNotifications');
        // dd($response->json());
        $this->assertEquals(sizeof($response->json()), 0);
        $response->assertStatus(200);

        


        UserNotification::factory(2)->create(['user_id' => $user->id]);
        $response = $this->get('api/userNotifications');
        $this->assertEquals(sizeof($response->json()), 2);
        $response->assertStatus(200);
    }

    public function test_user_can_be_notified()
    {
        $user = User::factory()->create();

        $user->createToken('mobile','expo token 1');
        $user->createToken('mobile','expo token 1');


        Http::shouldReceive('withHeaders->post')
            ->once();
        // ->with($Tos);

        $user->notify(new MessageNotification('title','body','user'));
    }


    public function test_user_login_and_logout_with_with_expo_token_to_subscribe_and_unsubscribe()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $response = $this->postJson('api/login', [
            'phone_number' => $user->phone_number,
            'password' => 'password',
            'device_name' => 'mobile',
            // 'expo_token' => $expo_token
        ])->assertStatus(422);
        $this->assertEquals(PersonalAccessToken::all()->count(), 0);


        $expo_token_from_mobile = '11111';
        $response = $this->postJson('api/login', [
            'phone_number' => $user->phone_number,
            'password' => 'password',
            'device_name' => 'mobile',
            'expo_token' => $expo_token_from_mobile
        ])->assertStatus(201);
        // $this->assertEquals(ExpoToken::all()->count(), 1);
        $this->assertEquals(PersonalAccessToken::all()->count(), 1);
        // dd($response->json()['token']);
        // $access_token = PersonalAccessToken::first()->plainTextToken;
        $access_token = $response->json()['token'];
        $this->withoutExceptionHandling();
        $response = $this->withHeaders([
            'Authorization' => ('Bearer ' . $access_token)
        ])->deleteJson(
            'api/logout'
        );
        $this->assertEquals(PersonalAccessToken::all()->count(), 0);
    }

    public function test_user_expoTokens_return_only_unique_tokens()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);
        $user->createToken('mobile','expo token 1');
        $user->createToken('mobile','expo token 1');
        $this->assertEquals($user->expoTokens()->count(),1);
        $user->createToken('mobile','expo token 2');
        $this->assertEquals($user->expoTokens()->count(),2);
    }

    public function test_user_can_retrive_all_his_tokens()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);
        $personal_access_token = $user->createToken('mobile','expo token 1');
        $personal_access_token = $user->createToken('mobile', 'expo token 2');
        $this->assertEquals($user->expoTokens()->count(), 2);
    }

}
