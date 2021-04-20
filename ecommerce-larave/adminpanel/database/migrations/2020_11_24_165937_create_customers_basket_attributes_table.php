<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersBasketAttributesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers_basket_attributes', function(Blueprint $table)
		{
			$table->integer('customers_basket_attributes_id', true);
			$table->integer('customers_basket_id');
			$table->integer('customers_id')->index('idx_customers_basket_att_customers_id');
			$table->text('products_id');
			$table->integer('products_options_id');
			$table->integer('products_options_values_id');
			$table->string('session_id', 191);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customers_basket_attributes');
	}

}
