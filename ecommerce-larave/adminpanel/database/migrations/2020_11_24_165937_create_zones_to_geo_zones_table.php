<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonesToGeoZonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zones_to_geo_zones', function(Blueprint $table)
		{
			$table->integer('association_id', true);
			$table->integer('zone_country_id')->index('idx_zones_to_geo_zones_country_id');
			$table->integer('zone_id')->nullable();
			$table->integer('geo_zone_id')->nullable();
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
		Schema::drop('zones_to_geo_zones');
	}

}
