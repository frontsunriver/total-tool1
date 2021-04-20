<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersBasketTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers_basket', function(Blueprint $table)
		{
			$table->integer('customers_basket_id', true);
			$table->integer('customers_id')->index('idx_customers_basket_customers_id');
			$table->text('products_id');
			$table->integer('customers_basket_quantity');
			$table->decimal('final_price', 15)->nullable();
			$table->char('customers_basket_date_added', 10)->nullable();
			$table->boolean('is_order')->default(0);
			$table->string('session_id', 191);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customers_basket');
	}

}
