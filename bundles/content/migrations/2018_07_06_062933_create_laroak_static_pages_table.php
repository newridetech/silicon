<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaroakStaticPagesTable extends Migration
{
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('laroak_static_pages');
    }

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('laroak_static_pages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('route')->unique();
            $table->timestamps();
        });
    }
}
