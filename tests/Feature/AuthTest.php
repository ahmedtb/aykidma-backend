<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthTest extends TestCase
{
    use DatabaseMigrations;


    public function test_only_auth_users_can_submit_orders()
    {
        $user = User::factory()->create();

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
            'service_id' => 1,
            'user_id' => 1,
            'fields' => $fields
        ]);


        $response->assertUnauthorized();

        $response = $this->actingAs($user)->postJson('api/orders', [
            'service_id' => 1,
            'user_id' => 1,
            'fields' => $fields
        ]);


        $response->assertStatus(200);
    }

    public function test_users_can_sign_in_and_get_access_tokens()
    {

        $user = User::factory()->create(['password' => Hash::make('password')]);

        $response = $this->postJson('api/login', [
            'number' => $user->number,
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
}
