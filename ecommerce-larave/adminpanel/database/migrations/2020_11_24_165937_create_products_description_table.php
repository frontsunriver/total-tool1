<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products_description', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('products_id');
			$table->integer('language_id')->default(1);
			$table->string('products_name', 64)->default('')->index('products_name');
			$table->text('products_description')->nullable();
			$table->string('products_url', 191)->nullable();
			$table->integer('products_viewed')->nullable()->default(0);
			$table->text('products_left_banner')->nullable();
			$table->integer('products_left_banner_start_date')->nullable();
			$table->integer('products_left_banner_expire_date')->nullable();
			$table->text('products_right_banner')->nullable();
			$table->integer('products_right_banner_start_date')->nullable();
			$table->integer('products_right_banner_expire_date')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products_description');
	}

}
