<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouncilLiabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('council_liabilities', function (Blueprint $table) {
            $table->string('council');
            $table->string('council_code');
            $table->string('secondary_council_code');
            $table->string('liabilities_total');
            $table->string('liabilities_per_person');
            $table->string('liabilities_as_percentage_of_assets');
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
        Schema::drop('council_liabilities');
    }
}
// LAD12CD  LAD12CDO    LAD12NM Long term liabilities, total (£,000)    Long term liabilities, per person (£,000)   Long-term liabilites as a pecentage of long-term assets (%)
