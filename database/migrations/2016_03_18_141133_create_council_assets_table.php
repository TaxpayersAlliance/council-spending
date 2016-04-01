<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouncilAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('council_assets', function (Blueprint $table) {
            $table->string('council');
            $table->string('council_code');
            $table->string('secondary_council_code');
            $table->string('golf_courses');
            $table->string('car_parks');
            $table->string('leisure_centres');
            $table->string('farms');
            $table->string('theatres');
            $table->string('pubs');
            $table->string('restaurants');
            $table->string('shopping_centres');
            $table->string('shops');
            $table->string('hotels');
            $table->string('other');
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
        Schema::drop('council_assets');
    }
}
// LAD12CD  LAD12CDO    LAD12NM Golf courses    Car parks   Swimming pools/leisure centre   Farms   Theatres    Pubs    Restaurants/cafes   Shopping centres    Shops   Hotels  Other
