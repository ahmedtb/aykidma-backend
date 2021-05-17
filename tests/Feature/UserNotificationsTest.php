<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Models\ExpoToken;
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
        $user = User::factory()->create();
        $this->actingAs($user, 'web');

        UserNotification::factory()->create();
        $response = $this->get('api/userNotifications');
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
        $token = ExpoToken::factory()->create([
            'personal_access_token_id' => $user->createToken('mobile')->accessToken->id
        ])->expo_token;
        $token = ExpoToken::factory()->create([
            'personal_access_token_id' => $user->createToken('mobile')->accessToken->id
        ])->expo_token;

        Http::shouldReceive('withHeaders->post')
            ->once();
        // ->with($Tos);

        $user->notify(new MessageNotification());
    }


    public function test_user_login_and_logout_with_with_expo_token_subscribtion_and_unsubscribtion()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $response = $this->postJson('api/login', [
            'phone_number' => $user->phone_number,
            'password' => 'password',
            'device_name' => 'mobile',
            // 'expo_token' => $expo_token
        ])->assertStatus(422);
        $this->assertEquals(ExpoToken::all()->count(), 0);


        $expo_token_from_mobile = '11111';
        $response = $this->postJson('api/login', [
            'phone_number' => $user->phone_number,
            'password' => 'password',
            'device_name' => 'mobile',
            'expo_token' => $expo_token_from_mobile
        ])->assertStatus(201);
        $this->assertEquals(ExpoToken::all()->count(), 1);
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
        $this->assertEquals(ExpoToken::all()->count(), 0);
    }

    public function test_user_can_retrive_all_his_tokens()
    {
        // dd(ExpoToken::factory()->create()->PersonalAccessToken()->get() );
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $personal_access_token = $user->createToken('mobile');
        ExpoToken::create([
            'personal_access_token_id' => $personal_access_token->accessToken->id,
            'expo_token' => '11111'
        ]);
        $personal_access_token = $user->createToken('mobile');
        ExpoToken::create([
            'personal_access_token_id' => $personal_access_token->accessToken->id,
            'expo_token' => '22222'
        ]);

        $this->assertEquals($user->expoTokens()->get()->count(), 2);
    }

    // public function test_user_can_subscribe_and_unsubscribe_from_notifications_tokens()
    // {
    //     $user = User::factory()->create();
    //     $personal_access_token = $user->createToken('mobile');
    //     // $this->actingAs($user,'web');
    //     $expoToken = ExpoToken::factory()
    //         ->make(['personal_access_tokens_id' => $personal_access_token->id]);

    //     $this->post('api/userNotifications/subscribe', [
    //         'token' => $expoToken->token
    //     ])->assertJson(
    //         ['success' => 'token is successfully registered']
    //     );

    //     $this->withExceptionHandling();
    //     $this->post('api/userNotifications/subscribe', [
    //         'token' => $expoToken->token
    //     ])->assertStatus(302);

    //     $this->delete('api/userNotifications/subscribe', [
    //         'token' => $expoToken->token
    //     ])->assertJson(
    //         ['success' => 'token is successfully omitted']
    //     );
    // }
}
