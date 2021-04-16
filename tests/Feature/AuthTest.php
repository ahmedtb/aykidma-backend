<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\activationNumber;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthTest extends TestCase
{
    use DatabaseMigrations;


    public function test_only_auth_users_can_submit_orders()
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();

        // testing valid request
        $fields = [
            [
                "label" => "اختر المنطقة",
                "type" => "options",
                "value" => "حي السلام"
            ],
            [
                "label" => "اختر نوع الغسيل",
                "type" => "options",
                "value" => "مفروشات"
            ],
        ];

        $response = $this->postJson('api/orders', [
            'service_id' => $service->id,
            'user_id' => 1,
            'fields' => $fields
        ]);


        $response->assertUnauthorized();

        $response = $this->actingAs($user)->postJson('api/orders', [
            'service_id' => $service->id,
            'user_id' => 1,
            'fields' => $fields
        ]);


        $response->assertStatus(200);
    }

    public function test_users_can_sign_in_and_get_access_tokens()
    {

        $user = User::factory()->create(['password' => Hash::make('password')]);

        $response = $this->postJson('api/login', [
            'phone_number' => $user->phone_number,
            'password' => 'password',
            'device_name' => 'mobile'
        ]);

        $response->assertStatus(201);

        
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

        $this->post('api/signup', [
            'name' => 'random name',
            'phone_number' => $phone_number,
            'password' => 'password',
            'activationNumber' => $activationNumber->activationNumber
        ])->assertStatus(201)->assertJson(['message' => 'user is successfully created']);
    }

    public function test_service_provider_can_enroll()
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
}
