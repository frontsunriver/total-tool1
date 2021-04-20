<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reviews', function(Blueprint $table)
		{
			$table->integer('reviews_id', true);
			$table->integer('products_id')->index('idx_reviews_products_id');
			$table->integer('customers_id')->nullable()->index('idx_reviews_customers_id');
			$table->string('customers_name', 191);
			$table->integer('reviews_rating')->nullable();
			$table->boolean('reviews_status')->default(0);
			$table->integer('reviews_read')->default(0);
			$table->integer('vendors_id')->nullable();
			$table->timestamps();
			$table->integer('deliveryboy_id')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reviews');
	}

}
