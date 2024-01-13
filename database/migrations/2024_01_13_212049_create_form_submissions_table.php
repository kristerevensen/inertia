<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormSubmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->string('project_code')->nullable();
            $table->string('form_id')->nullable();
            $table->string('form_name')->nullable();
            $table->string('page_url');
            $table->json('form_data'); // Storing submitted data as JSON
            $table->timestamps();

            // Foreign key relation, if you have project codes in another table
            $table->foreign('project_code')->references('project_code')->on('projects')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_submissions');
    }git
}
