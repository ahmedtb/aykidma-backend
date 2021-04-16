<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ServiceProvider;
use App\Models\activationNumber;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProviderAuthTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_service_provider_can_login_to_his_account_and_get_access_token()
    {
        // $this->withoutExceptionHandling();

        $provider = ServiceProvider::factory()->create(['password' => Hash::make('password') ]);
        $response = $this->postJson('api/loginProvider',
        [
            'phone_number' => $provider->phone_number,
            'password' => 'password'
        ]);

        $response->assertStatus(200);

        
        $response->assertJsonStructure([
            'provider',
            'token'
        ]);
    }

    public function test_provider_can_logout()
    {
        $this->withoutExceptionHandling();

        $provider = ServiceProvider::factory()->create();

        $token = $provider->createToken('mobile');
        // dd($token);
        

        $response = $this->withHeaders([
            'Authorization' => ('Bearer ' . $token->plainTextToken)
        ])->deleteJson(
            'api/logoutProvider'
        );
        $response->assertStatus(200);

        $this->assertNull(PersonalAccessToken::where('id',$token->accessToken->id)->first());

    }

    public function test_user_can_enroll_to_be_a_service_provider()
    {
        $this->withoutExceptionHandling();

        $fake_name = 'random name';
        $fake_phone_number = '0914354173';
        $fake_password = 'password';
        $this->post('api/enrollProvider', [
            'name' => $fake_name,
            'phone_number' => $fake_phone_number,
            'password' => $fake_password
        ])->assertStatus(201);

        $activationNumber = activationNumber::where('phone_number',$fake_phone_number)->first();

        // wrong activation number
        $this->post('api/enrollProvider', [
            'name' => $fake_name,
            'phone_number' => $fake_phone_number,
            'password' => $fake_password,
            'activationNumber' => 1111
        ])->assertStatus(422)->assertJson(['message' => 'the activation number is wrong']);

        $this->post('api/enrollProvider', [
            'name' => $fake_name,
            'phone_number' => $fake_phone_number,
            'password' => $fake_password,
            'activationNumber' => $activationNumber->activationNumber
        ])->assertStatus(201)->assertJson(['message' => 'provider is successfully created']);
    }

    public function test_users_can_not_access_providers_routes()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->getJson('api/myServices')->assertUnauthorized();
    }
}
