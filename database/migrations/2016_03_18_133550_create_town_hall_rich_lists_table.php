<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTownHallRichListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('town_hall_rich_lists', function (Blueprint $table) {
            $table->string('council');
            $table->string('council_code');
            $table->string('secondary_council_code');
            $table->string('employees100');
            $table->string('employees150');
            $table->timestamps();
            $table->increments('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('town_hall_rich_lists');
    }
}
// LAD12CD  LAD12CDO    LAD12NM Number of employees over £100,000   Number of employees over £150,000