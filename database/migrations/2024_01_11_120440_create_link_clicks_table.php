<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('link_clicks', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->string('link_url');
            $table->string('url_code');
            $table->string('event_type');
            $table->string('link_text')->nullable();
            $table->string('click_class')->nullable();
            $table->string('click_id')->nullable();
            $table->text('data_attributes')->nullable();
            $table->string('page_url');
            $table->string('click_type');
            $table->integer('coordinates_x');
            $table->integer('coordinates_y');
            $table->varchar('coordinates');
            $table->string('project_code', 10)->unique(); // uniqye ID per project
            $table->foreign('project_code')->references('project_code')->on('projects'); // foreign key constraint
            $table->foreign('url_code')->references('url_code')->on('data_pages');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_clicks');
    }
};
