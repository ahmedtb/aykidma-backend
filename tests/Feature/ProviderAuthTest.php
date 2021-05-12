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

        $fake_name = 'random name';
        $fake_phone_number = '0914354173';
        $fake_email = 'email@email.com';
        $fake_password = 'password';
        $address = [
            'city' => 'tripoli',
            'area' => 'area1',
            'subArea' => 'subArea1'
        ];
        $coverage = [
            [
                'city' => 'tripoli',
                'area' => 'area1',
            ],
            [
                'city' => 'benghazi',
                'area' => 'area2',
            ],
            [
                'city' => 'misrata',
                'area' => 'area1',
            ]
        ];
        $this->withoutExceptionHandling();
        $response=$this->postJson('api/enrollProvider', [
            'name' => $fake_name,
            'phone_number' => $fake_phone_number,
            'email' => $fake_email,
            'password' => $fake_password,
            'address' => $address,
            'coverage' => $coverage,
        ]);
        // dd($response->json());
        $response->assertStatus(201);

        $activationNumber = activationNumber::where('phone_number',$fake_phone_number)->first();

        // wrong activation number
        $this->postJson('api/enrollProvider', [
            'name' => $fake_name,
            'phone_number' => $fake_phone_number,
            'email' => $fake_email,
            'password' => $fake_password,
            'address' => $address,
            'coverage' => $coverage,
            'activationNumber' => 1111
        ])->assertStatus(422)->assertJson(['message' => 'the activation number is wrong']);


        $response = $this->postJson('api/enrollProvider', [
            'name' => $fake_name,
            'phone_number' => $fake_phone_number,
            'email' => $fake_email,
            'password' => $fake_password,
            'address' => $address,
            'coverage' => $coverage,
            'activationNumber' => $activationNumber->activationNumber
        ]);
        // dd($response->json());
        $response->assertStatus(201)->assertJson(['message' => 'provider is successfully created']);
    }

    public function test_users_can_not_access_providers_routes()
    {
        $user = User::factory()->create();
        $this->actingAs($user,'web')->getJson('api/myServices')->assertUnauthorized();
    }
}
