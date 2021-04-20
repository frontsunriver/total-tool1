<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersBalanceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_balance', function(Blueprint $table)
		{
			$table->integer('users_balance_id', true);
			$table->integer('users_id');
			$table->integer('orders_id');
			$table->integer('products_id');
			$table->string('transaction_type', 5)->comment('in: debit, credit:out');
			$table->decimal('amount', 10);
			$table->string('status', 191)->nullable();
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
		Schema::drop('users_balance');
	}

}
