<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_code')->key();
            $table->string('campaign_token')->key();
            $table->string('name');
            $table->foreign('project_code')->references('project_code')->on('projects'); // foreign key constraint
            $table->foreign('campaign_token')->references('campaign_token')->on('campaigns')->onDelete('cascade');
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
        Schema::dropIfExists('campaigns_category');
    }
}
