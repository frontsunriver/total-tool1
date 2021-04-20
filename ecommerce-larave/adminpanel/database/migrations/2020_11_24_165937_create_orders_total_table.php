<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTotalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders_total', function(Blueprint $table)
		{
			$table->increments('orders_total_id');
			$table->integer('orders_id')->index('idx_orders_total_orders_id');
			$table->string('title', 191);
			$table->string('text', 191);
			$table->decimal('value', 15, 4);
			$table->string('class', 32);
			$table->integer('sort_order');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders_total');
	}

}
