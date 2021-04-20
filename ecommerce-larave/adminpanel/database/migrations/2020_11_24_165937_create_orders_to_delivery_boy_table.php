<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersToDeliveryBoyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders_to_delivery_boy', function(Blueprint $table)
		{
			$table->integer('orders_to_deliveryboy_id', true);
			$table->integer('deliveryboy_id')->unsigned();
			$table->integer('orders_id')->unsigned();
			$table->boolean('is_current')->default(1);
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
		Schema::drop('orders_to_delivery_boy');
	}

}
