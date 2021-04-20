<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersStatusHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders_status_history', function(Blueprint $table)
		{
			$table->integer('orders_status_history_id', true);
			$table->integer('orders_id')->index('idx_orders_status_history_orders_id');
			$table->integer('orders_status_id');
			$table->dateTime('date_added');
			$table->integer('customer_notified')->nullable()->default(0);
			$table->text('comments')->nullable();
			$table->boolean('role_id')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders_status_history');
	}

}
