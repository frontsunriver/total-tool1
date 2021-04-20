<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeoZonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('geo_zones', function(Blueprint $table)
		{
			$table->integer('geo_zone_id', true);
			$table->string('geo_zone_name', 32);
			$table->string('geo_zone_description', 191);
			$table->dateTime('last_modified')->nullable();
			$table->dateTime('date_added');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('geo_zones');
	}

}
