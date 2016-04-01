<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postcodes', function (Blueprint $table) {
            
            $table->string('postcode');
            $table->integer('positional_quality_indicator');
            $table->integer('eastings');
            $table->integer('northings');
            $table->string('country_lookup_id')->nullable;
            $table->string('NHS_regional_HA_code')->nullable;
            $table->string('nhs_lookup_id')->nullable;
            $table->string('county_lookup_id')->nullable;
            $table->string('district_lookup_id')->nullable;
            $table->string('ward_lookup_id')->nullable;
            $table->increments('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('postcodes');
    }
}
