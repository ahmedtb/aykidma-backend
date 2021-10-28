<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('user_id')->uniqid();
            $table->boolean('activated');
            // $table->string('phone_number')->unique()->nullable();
            // $table->timestamp('phone_number_verified_at')->nullable();
            // $table->string('email')->unique()->nullable();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('password');
            // $table->json('address');
            $table->json('coverage');
            $table->mediumText('image')->nullable();

            $table->json('meta_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_providers');
    }
}
