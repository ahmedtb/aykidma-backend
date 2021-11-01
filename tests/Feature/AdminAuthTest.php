<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;


    public function test_admin_can_login_and_logout(){
        $admin = Admin::factory()->create();
        $response = $this->postJson('/api/dashboard/loginAdmin',[
            'phone_number'=>$admin->phone_number,
            'password'=>'password',
        ]);
        // $response->assertOk();
        dd($response->json());
    }



}
