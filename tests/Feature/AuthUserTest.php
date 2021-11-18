<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use App\Models\activationNumber;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthUserTest extends TestCase
{
    use DatabaseMigrations;




    public function test_users_can_sign_in_and_get_access_tokens()
    {

        $user = User::factory()->create(['password' => Hash::make('password')]);

        $testing_expo_token = '11111';
        $response = $this->postJson('api/login', [
            'phone_number' => $user->phone_number,
            'password' => 'password',
            'device_name' => 'mobile',
            'expo_token' => $testing_expo_token
        ]);
        $response->assertStatus(201);

        $response->assertJsonStructure([
            'user',
            'token'
        ]);
    }

    public function test_user_can_logout()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $token = $user->createToken('mobile', '11111')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => ('Bearer ' . $token)
        ])->deleteJson(
            'api/logout'
        );
        $response->assertStatus(200);

        $this->assertNull(PersonalAccessToken::where('token', $token)->first());
    }

    public function test_a_user_can_sign_up_and_get_activation_phone_number_through_whatsapp_message()
    {
        $this->withoutExceptionHandling();

        $phone_number = '0914354173';
        $this->post('api/signup', [
            'name' => 'random name',
            'phone_number' => $phone_number,
            'password' => 'password'
        ])->assertStatus(201)->assertJson(['message' => 'user is successfully created']);

        // $activationNumber = activationNumber::where('phone_number', $phone_number)->first();

        // // wrong activation number
        // $this->post('api/signup', [
        //     'name' => 'random name',
        //     'phone_number' => $phone_number,
        //     'password' => 'password',
        //     'activationNumber' => 1111
        // ])->assertStatus(422)->assertJson(['message' => 'the activation number is wrong']);

        // // right activation number
        // $this->post('api/signup', [
        //     'name' => 'random name',
        //     'phone_number' => $phone_number,
        //     'password' => 'password',
        //     'activationNumber' => $activationNumber->activationNumber
        // ])->assertStatus(201)->assertJson(['message' => 'user is successfully created']);
    }

    public function test_only_authenticated_user_can_retrive_orders()
    {
        $user = User::factory()->create();
        Order::factory()->count(10)->create(['user_id' => $user->id]);


        $response = $this->getJson('api/userOrders');
        $response->assertUnauthorized();

        $response = $this->getJson('api/orders/1');
        $response->assertUnauthorized();

        $this->actingAs($user, 'user');

        $response = $this->getJson('api/userOrders');
        // dd($response->json());
        $response->assertOk();

        $response = $this->getJson('api/orders/1');
        $response->assertOk();
    }

    public function test_user_data_return_does_not_contain_image()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $testing_expo_token = '11111';
        $response = $this->postJson('api/login', [
            'phone_number' => $user->phone_number,
            'password' => 'password',
            'device_name' => 'mobile',
            'expo_token' => $testing_expo_token
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'user',
            'token'
        ]);
        $this->assertArrayNotHasKey('image', $response->json()['user']);
    }

    public function test_user_can_fetch_his_image()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'user')->getJson('api/user/image')->assertOk();

        // assert it is valid base64 image
        $image = $response->content();
        $this->assertTrue(isValidBase64($image));
    }

    public function test_user_can_edit_his_profile()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->make();

        $response = $this->actingAs($user, 'user')->postJson('api/user/edit', [
            'name' => $user2->name,
            // 'phone_number' => $user2->phone_number,
            'image' => $user2->image,
        ])->assertOk();

        // dd($response->json());

        $response = $this->actingAs($user, 'user')->postJson('api/user/edit', [
            // 'name' => $user2->name,
            'phone_number' => $user2->phone_number,
            // 'image' => $user2->image,
        ])->assertOk();
    }

    public function test_user_can_get_fresh_data_of_his_profile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'user')->getJson('api/user')->assertOk();
        $response->assertJsonStructure([
            'name','phone_number','updated_at','created_at','id'
        ]);
    }
}
