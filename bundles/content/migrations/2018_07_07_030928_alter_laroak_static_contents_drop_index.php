<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLaroakStaticContentsDropIndex extends Migration
{
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('laroak_static_contents', function (Blueprint $table) {
            $table->unique('owner_id');
            $table->index('owner_type');
        });
    }

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('laroak_static_contents', function (Blueprint $table) {
            $table->dropUnique(['owner_id']);
            $table->dropIndex(['owner_type']);
        });
    }
}
