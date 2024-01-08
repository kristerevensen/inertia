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
        Schema::create('data_pages_filters', function (Blueprint $table) {
            $table->id();
            $table->string('project_code'); //project code
            $table->text('filters'); //serialized array of url parameters to be removed from the urls
            $table->foreign('project_code_ref')->references('project_code')->on('projects'); // foreign key constraint
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pages_filters');
    }
};
