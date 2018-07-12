<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLaroakStaticContentsAddCombinedIndex extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('laroak_static_contents', function (Blueprint $table) {
            $table->unique(['owner_id', 'owner_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('laroak_static_contents', function (Blueprint $table) {
            $table->dropUnique(['owner_id', 'owner_type']);
        });
    }
}
