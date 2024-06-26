<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clicks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->string('ip')->nullable();
            $table->string('platform')->nullable();
            $table->string('link_token')->key()->index();
            $table->timestamps();
            $table->string('clicks_link_token');  // Make sure this line exists
            $table->foreign('clicks_link_token')->references('link_token')->on('campaigns_links')->onDelete('cascade');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('clicks');
    }
}
