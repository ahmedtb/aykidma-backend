<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceProvider;
use App\Models\activationNumber;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReportsSystemTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_can_report_about_inapproperite_review_or_SP_profile_or_service(){
        $user = User::factory()->create();
        
        $review = Review::factory()->create();
        $response = $this->actingAs($user,'user')->postJson('api/reportReview',[
            'review_id' => $review->id,
            'body' => 'aaaaaaaaaaaaaaaaaaa'
        ]);

        $response->assertStatus(201);

        
        $ServiceProvider = ServiceProvider::factory()->create();
        $response = $this->actingAs($user,'user')->postJson('api/reportSP',[
            'service_provider_id' => $ServiceProvider->id,
            'body' => 'aaaaaaaaaaaaaaaaaaa'
        ]);

        $response->assertStatus(201);

        $Service = Service::factory()->create();
        $response = $this->actingAs($user,'user')->postJson('api/reportService',[
            'service_id' => $Service->id,
            'body' => 'aaaaaaaaaaaaaaaaaaa'
        ]);

        $response->assertStatus(201);
    }

}