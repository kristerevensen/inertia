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
        Schema::create('campaigns_custom_parameters', function (Blueprint $table) {
            $table->id();
            $table->increments('id');
            $table->string('custom_parameter');
            $table->string('project_token');
            $table->enum('required',array('1','0'))->default('0');
            $table->enum('automatic',array('1','0'))->default('0');
            $table->enum('active',array('1','0'))->default('1');
            $table->string('prefix')->nullable();
            $table->text('description')->nullable();
            $table->foreign('project_code')->references('project_code')->on('projects'); // foreign key constraint
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns_custom_parameters');
    }
};
