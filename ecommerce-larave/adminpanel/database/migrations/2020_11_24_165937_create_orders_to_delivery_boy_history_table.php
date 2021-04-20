<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersToDeliveryBoyHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders_to_delivery_boy_history', function(Blueprint $table)
		{
			$table->integer('orders_to_delivery_boy_history_id', true);
			$table->integer('orders_id')->unsigned();
			$table->integer('orders_to_deliveryboy_id')->unsigned();
			$table->boolean('commented_person');
			$table->integer('commented_person_id')->unsigned();
			$table->boolean('is_current')->default(1);
			$table->text('comments')->nullable();
			$table->timestamps();
			$table->integer('orders_status_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders_to_delivery_boy_history');
	}

}
