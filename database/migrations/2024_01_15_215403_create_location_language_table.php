<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationLanguageTable extends Migration
{
    public function up()
    {
        Schema::create('location_language', function (Blueprint $table) {
            $table->foreignId('location_code')->constrained('locations');
            $table->foreignId('language_id')->constrained('languages');
            $table->json('available_sources');
            $table->bigInteger('keywords');
            $table->bigInteger('serps');
            $table->timestamps();

            $table->primary(['location_code', 'language_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('location_language');
    }
}
