<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryboyInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('deliveryboy_info', function(Blueprint $table)
		{
			$table->integer('deliveryboy_info_id', true);
			$table->integer('users_id')->unsigned();
			$table->string('blood_group', 100);
			$table->string('bike_name', 100);
			$table->text('bike_details');
			$table->string('bike_color', 100);
			$table->string('owner_name', 100);
			$table->string('vehicle_registration_number', 100);
			$table->string('driving_license_image', 191)->nullable();
			$table->string('vehicle_rc_book_image', 191)->nullable();
			$table->boolean('availability_status')->default(1);
			$table->decimal('commission', 10);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('deliveryboy_info');
	}

}
