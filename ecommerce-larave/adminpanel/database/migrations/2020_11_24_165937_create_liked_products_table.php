<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikedProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('liked_products', function(Blueprint $table)
		{
			$table->integer('like_id', true);
			$table->integer('liked_products_id');
			$table->integer('liked_customers_id');
			$table->dateTime('date_liked')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('liked_products');
	}

}
