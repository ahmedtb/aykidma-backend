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
            $table->boolean("approved")->default(false);
            $table->string('title');
            $table->longText('description');
            $table->json('array_of_fields');
            $table->foreignId('category_id');
            $table->mediumText('image');
            $table->json('meta_data')->nullable();
            $table->unsignedSmallInteger('price')->nullable();
            $table->string('phone_number')->nullable();
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
