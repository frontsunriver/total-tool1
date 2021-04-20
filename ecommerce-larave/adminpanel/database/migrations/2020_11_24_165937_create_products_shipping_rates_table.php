<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsShippingRatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products_shipping_rates', function(Blueprint $table)
		{
			$table->integer('products_shipping_rates_id', true);
			$table->string('weight_from', 100)->nullable();
			$table->string('weight_to', 100)->nullable();
			$table->integer('weight_price');
			$table->integer('unit_id');
			$table->boolean('products_shipping_status')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products_shipping_rates');
	}

}
