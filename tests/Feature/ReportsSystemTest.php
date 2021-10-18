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

class ReportsSystemTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_can_report_about_inapproperite_comment(){

    }
    
    public function test_user_can_report_about_inapproperite_SP_profile(){

    }

}