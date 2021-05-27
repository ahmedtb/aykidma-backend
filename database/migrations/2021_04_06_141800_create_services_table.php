<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId("service_provider_id");
            // $table->foreignId("offer_id");
            // $table->json("meta_data")->nullable();
            // $table->unsignedDecimal("rating")->nullable(); this field should be in meta_data
            $table->boolean("approved")->default(false);

            $table->string('title');
            $table->longText('description');
            $table->json('fields');
            $table->foreignId('category_id');
            $table->string('image')->default('https://www.mintformations.co.uk/blog/wp-content/uploads/2020/05/shutterstock_583717939.jpg');
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
        Schema::dropIfExists('services');
    }
}
