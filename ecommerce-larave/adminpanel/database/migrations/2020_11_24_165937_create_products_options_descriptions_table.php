<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsOptionsDescriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products_options_descriptions', function(Blueprint $table)
		{
			$table->integer('products_options_descriptions_id', true);
			$table->integer('language_id');
			$table->string('options_name', 191)->nullable();
			$table->integer('products_options_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products_options_descriptions');
	}

}
