<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpsShippingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ups_shipping', function(Blueprint $table)
		{
			$table->integer('ups_id', true);
			$table->string('pickup_method', 191);
			$table->string('isDisplayCal', 191);
			$table->string('serviceType', 191);
			$table->string('shippingEnvironment', 191);
			$table->string('user_name', 191);
			$table->string('access_key', 191);
			$table->string('password', 191);
			$table->string('person_name', 191);
			$table->string('company_name', 191);
			$table->string('phone_number', 191);
			$table->string('address_line_1', 191);
			$table->string('address_line_2', 191);
			$table->string('country', 191);
			$table->string('state', 191);
			$table->string('post_code', 191);
			$table->string('city', 191);
			$table->string('no_of_package', 191);
			$table->string('parcel_height', 191);
			$table->string('parcel_width', 191);
			$table->string('title', 191);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ups_shipping');
	}

}
