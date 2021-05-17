<?php

namespace Tests\Feature;

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

        // $this->mock->shouldReceive('remember->with->notSold->take->orderBy->get')
        //     ->andRe‌​turn($this->collection);
        // $mock = $this->partialMock(PendingRequest::class, function (MockInterface $mock) {
        //     $mock->shouldReceive('post')->once();
        // });

        $user = User::factory()->create();
        $tokens = ExpoToken::factory(2)->create(['notifiable_id' => $user->id])->pluck('token');
        // dd($tokens);
        // ExpoToken::factory()->create(['notifiable_id'=>$user->id]);
        Http::shouldReceive('withHeaders->post')
            ->once();
        // ->with(['to' => $tokens, 'title' => 'طلب وجبة', 'body' => 'message']);

        $user->notify(new MessageNotification());
    }

    public function test_user_can_subscribe_and_unsubscribe_from_notifications_tokens()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $expoToken = ExpoToken::factory()->make(['notifiable_id' => $user->id]);

        $this->post('api/userNotifications/subscribe', [
            'token' => $expoToken->token
        ])->assertJson(
            ['success' => 'token is successfully registered']
        );

        $this->withExceptionHandling();
        $this->post('api/userNotifications/subscribe', [
            'token' => $expoToken->token
        ])->assertStatus(302);

        $this->delete('api/userNotifications/subscribe', [
            'token' => $expoToken->token
        ])->assertJson(
            ['success' => 'token is successfully omitted']
        );
    }

    public function test_user_must_send_expo_token_when_login()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create(['password' => Hash::make('password')]);
        $expo_token = '11111';

        $response = $this->postJson('api/login', [
            'phone_number' => $user->phone_number,
            'password' => 'password',
            'device_name' => 'mobile',
            // 'expo_token' => $expo_token
        ]);
        $response->assertStatus(422);


        $response = $this->postJson('api/login', [
            'phone_number' => $user->phone_number,
            'password' => 'password',
            'device_name' => 'mobile',
            'expo_token' => $expo_token
        ]);
        // dd($response->json());
        $response->assertStatus(201);

        $response->assertJsonStructure([
            'user',
            'token'
        ]);
    }

    public function test_user_can_retrive_all_his_tokens() {
        $user = User::factory()->create(['password' => Hash::make('password')]);
        
        $personal_access_tokens = $user->createToken('mobile');
        $expo_token = ExpoToken::create([
            'personal_access_tokens_id' => $personal_access_tokens->accessToken->id,
            'expo_token' => '11111'
        ]);
        $personal_access_tokens = $user->createToken('mobile');
        $expo_token = ExpoToken::create([
            'personal_access_tokens_id' => $personal_access_tokens->accessToken->id,
            'expo_token' => '22222'
        ]);
        // dd($expo_token->personalAccessToken()->get());

        // $user = User::factory()->create(['password' => Hash::make('password')]);
        // $expo_token = '11111';

        // $response = $this->postJson('api/login', [
        //     'phone_number' => $user->phone_number,
        //     'password' => 'password',
        //     'device_name' => 'mobile',
        //     'expo_token' => $expo_token
        // ]);

        // $response = $this->postJson('api/login', [
        //     'phone_number' => $user->phone_number,
        //     'password' => 'password',
        //     'device_name' => 'mobile',
        //     'expo_token' => '22222'
        // ]);
        // $this->withoutExceptionHandling();
    //    dd(ExpoToken::all());
        dd($user->expoTokens()->get() );
    }
}
