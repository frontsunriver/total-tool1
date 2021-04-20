<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products_images', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('products_id')->index('products_images_prodid');
			$table->text('image')->nullable();
			$table->text('htmlcontent')->nullable();
			$table->integer('sort_order');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products_images');
	}

}
