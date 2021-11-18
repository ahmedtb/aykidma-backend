<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Database\Seeder;
use App\Models\UserNotification;
use App\Models\ProviderNotification;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::factory()->create([
            'phone_number' => '0914354173',
        ]);
        $user = User::factory()->create([
            'phone_number' => '0914354173',
            'password' => Hash::make('password')
        ]);
        // $provider = ServiceProvider::factory()->activated()->forUser($user)->create();
        // Service::factory()->approved()->forProvider($provider)->create();

        $users = User::factory(10)->create();
        foreach ($users as $user) {
            $provider = ServiceProvider::factory()->activated()->forUser($user)->create();
            Service::factory(3)->approved()->forProvider($provider)->create();
        }

        Service::factory(10)->approved(false)->create();

        Order::factory(40)->create();
        Review::factory(40)->create();

        UserNotification::factory(100)->create();
        ProviderNotification::factory(100)->create();
    }
}
