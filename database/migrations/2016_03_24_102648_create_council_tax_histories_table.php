<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouncilTaxHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('council_tax_histories', function (Blueprint $table) {
            $table->string('council');
            $table->string('council_code');
            $table->string('secondary_council_code');
            $table->string('real_terms_increase');
            $table->string('number_of_increases');
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
        Schema::drop('council_tax_histories');
    }
}
