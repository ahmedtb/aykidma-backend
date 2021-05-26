<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Order::factory(10)->create();
        \App\Models\Admin::factory()->create();
        \App\Models\UserNotification::factory(10)->create(['user_id'=>1]);
        \App\Models\ProviderNotification::factory(10)->create(['service_provider_id'=>1]);
    }
}
