<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders_products', function(Blueprint $table)
		{
			$table->integer('orders_products_id', true);
			$table->integer('orders_id')->index('idx_orders_products_orders_id');
			$table->integer('products_id')->index('idx_orders_products_products_id');
			$table->string('products_model', 12)->nullable();
			$table->string('products_name', 64);
			$table->decimal('products_price', 15);
			$table->decimal('final_price', 15);
			$table->decimal('products_tax', 7, 0);
			$table->integer('products_quantity');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders_products');
	}

}
