<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkClicksTable extends Migration
{
    public function up()
    {
        Schema::create('data_link_clicks', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->string('link_url');
            $table->string('url_code');
            $table->string('link_text')->nullable();
            $table->string('click_class')->nullable();
            $table->string('click_id')->nullable();
            $table->text('data_attributes')->nullable();
            $table->string('page_url');
            $table->string('click_type');
            $table->integer('coordinates_x');
            $table->integer('coordinates_y');
            $table->string('project_code', 10)->unique(); // uniqye ID per project
            $table->foreign('project_code')->references('project_code')->on('projects'); // foreign key constraint
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_link_clicks');
    }
}
