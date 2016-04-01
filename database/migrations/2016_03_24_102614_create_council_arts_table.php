<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouncilArtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('council_arts', function (Blueprint $table) {
            $table->string('council');
            $table->string('council_code');
            $table->string('secondary_council_code');
            $table->string('total_number');
            $table->string('total_on_display');
            $table->string('value');
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
        Schema::drop('council_arts');
    }
}
