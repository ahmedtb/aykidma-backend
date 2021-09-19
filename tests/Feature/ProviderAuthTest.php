<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Admin;
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

    public function test_service_provider_is_linked_to_a_user_and_login_with_the_same_credientials()
    {
        $provider = ServiceProvider::factory()->create();
        $this->assertNotNull($provider->user_id);
        $this->assertTrue($provider->user instanceof User);
        // dd($provider->user->provider);
        $this->assertTrue($provider->user->provider instanceof ServiceProvider);
    }

    public function test_service_provider_of_user_can_be_activated_or_not()
    {
        $provider = ServiceProvider::factory()->create();
        $this->assertIsBool($provider->activated);
    }

    public function test_service_provider_will_be_logged_in_with_his_user_login_if_its_activated()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);
        $provider = ServiceProvider::factory()->create([
            'activated' => true,
            'user_id' => $user->id
        ]);

        $testing_expo_token = '11111';
        $response = $this->postJson('api/login', [
            'phone_number' => $provider->user->phone_number,
            'password' => 'password',
            'device_name' => 'mobile',
            'expo_token' => $testing_expo_token
        ]);
        $response->assertStatus(201);

        $response->assertJsonStructure([
            'user',
            'token'
        ]);

        $response = $this->actingAs($provider->user, 'sanctum')->getJson('api/provider')->assertOk();
        $response->assertJsonStructure([
            'name', 'user_id', 'coverage', 'meta_data', 'updated_at', 'created_at', 'id'
        ]);
    }

    // public function test_provider_can_logout()
    // {
    //     $this->withoutExceptionHandling();

    //     $provider = ServiceProvider::factory()->create();

    //     $token = $provider->createToken('mobile', '11111');
    //     // dd($token);


    //     $response = $this->withHeaders([
    //         'Authorization' => ('Bearer ' . $token->plainTextToken)
    //     ])->deleteJson(
    //         'api/logoutProvider'
    //     );
    //     $response->assertStatus(200);

    //     $this->assertNull(PersonalAccessToken::where('id', $token->accessToken->id)->first());
    // }

    public function test_user_can_enroll_to_be_a_service_provider_and_admins_can_reject_or_accept_the_activation()
    {

        $provider = ServiceProvider::factory()->create([
            'activated' => false
        ]);
        $fake_name = 'random name';
        $coverage = [
            [
                'city' => 'tripoli',
                'area' => 'area1',
            ],
            [
                'city' => 'benghazi',
                'area' => 'area2',
            ]
        ];
        $this->withoutExceptionHandling();
        $response = $this->postJson('api/enrollProvider', [
            'name' => $fake_name,
            // 'phone_number' => $fake_phone_number,
            // 'email' => $fake_email,
            // 'password' => $fake_password,
            // 'address' => $address,
            'coverage' => $coverage,
            'user_id' => $provider->user->id
        ]);
        $response->assertStatus(200)->assertJson(['success' => 'provider enrollemnt is submitted']);

        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admin')->putJson('api/approve/provider', [
            'user_id' => $provider->user->id
        ])->assertOK()->assertJson(['success' => 'the provider has been approved']);
        // dd($response->json());
    }

    public function test_users_can_not_access_providers_routes()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'web')->getJson('api/myServices')->assertUnauthorized();
    }

    public function test_Provider_can_get_fresh_data_of_his_profile()
    {
        $Provider = ServiceProvider::factory()->create();
        $response = $this->actingAs($Provider, 'web')->getJson('api/provider')->assertOk();
        $response->assertJsonStructure([
            'name', 'phone_number', 'email', 'address', 'coverage', 'image', 'meta_data', 'updated_at', 'created_at', 'id'
        ]);
    }
}
