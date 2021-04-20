<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsAttributesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products_attributes', function(Blueprint $table)
		{
			$table->integer('products_attributes_id', true);
			$table->integer('products_id')->index('idx_products_attributes_products_id');
			$table->integer('options_id');
			$table->integer('options_values_id');
			$table->decimal('options_values_price', 15);
			$table->char('price_prefix', 1);
			$table->boolean('is_default')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products_attributes');
	}

}
