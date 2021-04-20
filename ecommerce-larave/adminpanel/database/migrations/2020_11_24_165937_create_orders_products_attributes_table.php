<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersProductsAttributesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders_products_attributes', function(Blueprint $table)
		{
			$table->integer('orders_products_attributes_id', true);
			$table->integer('orders_id')->index('idx_orders_products_att_orders_id');
			$table->integer('orders_products_id');
			$table->integer('products_id');
			$table->string('products_options', 32);
			$table->string('products_options_values', 32);
			$table->decimal('options_values_price', 15);
			$table->char('price_prefix', 1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders_products_attributes');
	}

}
