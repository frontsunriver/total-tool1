<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsOptionsValuesDescriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products_options_values_descriptions', function(Blueprint $table)
		{
			$table->integer('products_options_values_descriptions_id', true);
			$table->integer('language_id');
			$table->string('options_values_name', 191);
			$table->integer('products_options_values_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products_options_values_descriptions');
	}

}
