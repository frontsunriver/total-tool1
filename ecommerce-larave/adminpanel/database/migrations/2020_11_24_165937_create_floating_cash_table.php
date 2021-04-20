<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFloatingCashTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('floating_cash', function(Blueprint $table)
		{
			$table->integer('floating_cash_id', true);
			$table->integer('deliveryboy_id');
			$table->integer('orders_id');
			$table->decimal('amount', 10);
			$table->string('status', 100);
			$table->timestamps();
			$table->integer('admin_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('floating_cash');
	}

}
