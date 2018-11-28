<?php

use Illuminate\Database\Migrations\Migration;

class UpdateLaroakStaticContentsOwner extends Migration
{
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('UPDATE laroak_static_contents SET owner_type = replace(owner_type, \'Silicon\', \'Laroak\')');
    }

    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement('UPDATE laroak_static_contents SET owner_type = replace(owner_type, \'Laroak\', \'Silicon\')');
    }
}
