<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLaroakStaticContentsAddOwnerType extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('laroak_static_contents', function (Blueprint $table) {
            $table->string('owner_type')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('laroak_static_contents', function (Blueprint $table) {
            $table->dropColumn('owner_type');
        });
    }
}
