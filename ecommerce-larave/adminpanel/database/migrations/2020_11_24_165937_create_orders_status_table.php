<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders_status', function(Blueprint $table)
		{
			$table->integer('orders_status_id', true);
			$table->integer('public_flag')->nullable()->default(0);
			$table->integer('downloads_flag')->nullable()->default(0);
			$table->integer('role_id')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders_status');
	}

}
