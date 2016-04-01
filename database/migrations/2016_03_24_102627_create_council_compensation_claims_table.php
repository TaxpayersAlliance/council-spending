<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouncilCompensationClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('council_compensation_claims', function (Blueprint $table) {
            $table->string('council');
            $table->string('council_code');
            $table->string('secondary_council_code');
            $table->string('2013-14');
            $table->string('2014-15');
            $table->string('total');
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
        Schema::drop('council_compensation_claims');
    }
}
