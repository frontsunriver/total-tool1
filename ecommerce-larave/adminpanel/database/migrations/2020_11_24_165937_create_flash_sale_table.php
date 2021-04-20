<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlashSaleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flash_sale', function(Blueprint $table)
		{
			$table->integer('flash_sale_id', true);
			$table->integer('products_id')->index('products_id');
			$table->decimal('flash_sale_products_price', 15);
			$table->integer('flash_sale_date_added');
			$table->integer('flash_sale_last_modified');
			$table->integer('flash_start_date');
			$table->integer('flash_expires_date');
			$table->boolean('flash_status')->default(1);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('flash_sale');
	}

}
