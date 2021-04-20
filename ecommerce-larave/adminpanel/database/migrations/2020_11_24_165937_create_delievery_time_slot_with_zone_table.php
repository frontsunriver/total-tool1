<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelieveryTimeSlotWithZoneTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('delievery_time_slot_with_zone', function(Blueprint $table)
		{
			$table->integer('delievery_time_slot_with_zone_id', true);
			$table->string('time_from', 33);
			$table->string('time_to', 33);
			$table->decimal('delivery_price', 15);
			$table->integer('zone_id')->unsigned();
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
		Schema::drop('delievery_time_slot_with_zone');
	}

}
