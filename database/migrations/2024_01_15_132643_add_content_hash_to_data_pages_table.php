<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
        Schema::table('data_pages', function (Blueprint $table) {
            $table->string('content_hash')->nullable()->after('outbound_links');
            $table->text('page_content')->nullable()->after('content_hash');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('data_pages', function (Blueprint $table) {
            $table->dropColumn('content_hash');
            $table->dropColumn('page_content');
        });
    }

};
