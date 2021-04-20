<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers_info', function(Blueprint $table)
		{
			$table->integer('customers_info_id')->primary();
			$table->dateTime('customers_info_date_of_last_logon')->nullable();
			$table->integer('customers_info_number_of_logons')->nullable();
			$table->dateTime('customers_info_date_account_created')->nullable();
			$table->dateTime('customers_info_date_account_last_modified')->nullable();
			$table->integer('global_product_notifications')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customers_info');
	}

}
