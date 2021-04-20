<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupons', function(Blueprint $table)
		{
			$table->integer('coupans_id', true);
			$table->string('code', 191);
			$table->dateTime('date_created')->nullable();
			$table->dateTime('date_modified')->nullable();
			$table->text('description')->nullable();
			$table->string('discount_type', 100)->comment('Options: fixed_cart, percent, fixed_product and percent_product. Default: fixed_cart.');
			$table->integer('amount');
			$table->dateTime('expiry_date');
			$table->integer('usage_count');
			$table->boolean('individual_use')->default(0);
			$table->string('product_ids', 191);
			$table->string('exclude_product_ids', 191);
			$table->integer('usage_limit')->nullable();
			$table->integer('usage_limit_per_user')->nullable();
			$table->integer('limit_usage_to_x_items');
			$table->boolean('free_shipping')->default(0);
			$table->string('product_categories', 191);
			$table->string('excluded_product_categories', 191);
			$table->boolean('exclude_sale_items')->default(0);
			$table->decimal('minimum_amount', 10);
			$table->decimal('maximum_amount', 10);
			$table->text('email_restrictions');
			$table->string('used_by', 191);
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
		Schema::drop('coupons');
	}

}
