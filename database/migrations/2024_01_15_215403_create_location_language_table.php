<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationLanguageTable extends Migration
{
    public function up()
    {
        Schema::create('location_language', function (Blueprint $table) {
            // Ensure these are the correct data types and match the related tables
            $table->unsignedBigInteger('location_code');
            $table->unsignedBigInteger('language_id');

            // Define the foreign keys
            $table->foreign('location_code')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');

            // Additional columns
            $table->json('available_sources');
            $table->bigInteger('keywords');
            $table->bigInteger('serps');
            $table->timestamps();

            // Composite primary key
            $table->primary(['location_code', 'language_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('location_language');
    }

}
