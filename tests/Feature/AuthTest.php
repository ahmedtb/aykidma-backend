<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\activationNumber;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\PersonalAccessToken;

class AuthTest extends TestCase
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

        $token = $user->createToken('mobile')->plainTextToken;

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
        ])->assertStatus(201);

        $activationNumber = activationNumber::where('phone_number',$phone_number)->first();

        // wrong activation number
        $this->post('api/signup', [
            'name' => 'random name',
            'phone_number' => $phone_number,
            'password' => 'password',
            'activationNumber' => 1111
        ])->assertStatus(422)->assertJson(['message' => 'the activation number is wrong']);

        // right activation number
        $this->post('api/signup', [
            'name' => 'random name',
            'phone_number' => $phone_number,
            'password' => 'password',
            'activationNumber' => $activationNumber->activationNumber
        ])->assertStatus(201)->assertJson(['message' => 'user is successfully created']);
    }

}
