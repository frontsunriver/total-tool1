<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->integer('orders_id', true);
			$table->decimal('total_tax', 7);
			$table->integer('customers_id')->index('idx_orders_customers_id');
			$table->string('customers_name', 191);
			$table->string('customers_company', 191)->nullable();
			$table->string('customers_street_address', 191);
			$table->string('customers_suburb', 191)->nullable();
			$table->string('customers_city', 191);
			$table->string('customers_postcode', 191);
			$table->string('customers_state', 191)->nullable();
			$table->string('customers_country', 191);
			$table->string('customers_telephone', 191);
			$table->string('email', 191);
			$table->integer('customers_address_format_id')->nullable();
			$table->string('delivery_name', 191);
			$table->string('delivery_company', 191)->nullable();
			$table->string('delivery_street_address', 191);
			$table->string('delivery_suburb', 191)->nullable();
			$table->string('delivery_city', 191);
			$table->string('delivery_postcode', 191);
			$table->string('delivery_state', 191)->nullable();
			$table->string('delivery_country', 191);
			$table->integer('delivery_address_format_id')->nullable();
			$table->string('billing_name', 191);
			$table->string('billing_company', 191)->nullable();
			$table->string('billing_street_address', 191);
			$table->string('billing_suburb', 191)->nullable();
			$table->string('billing_city', 191);
			$table->string('billing_postcode', 191);
			$table->string('billing_state', 191)->nullable();
			$table->string('billing_country', 191);
			$table->integer('billing_address_format_id');
			$table->string('payment_method', 191)->nullable();
			$table->string('cc_type', 20)->nullable();
			$table->string('cc_owner', 191)->nullable();
			$table->string('cc_number', 32)->nullable();
			$table->string('cc_expires', 4)->nullable();
			$table->dateTime('last_modified')->nullable();
			$table->dateTime('date_purchased')->nullable();
			$table->dateTime('orders_date_finished')->nullable();
			$table->char('currency', 3)->nullable();
			$table->decimal('currency_value', 14, 6)->nullable();
			$table->decimal('order_price', 10);
			$table->decimal('shipping_cost', 10);
			$table->string('shipping_method', 100);
			$table->integer('shipping_duration')->nullable();
			$table->text('order_information');
			$table->boolean('is_seen')->default(0);
			$table->text('coupon_code');
			$table->integer('coupon_amount');
			$table->string('exclude_product_ids', 191);
			$table->string('product_categories', 191);
			$table->string('excluded_product_categories', 191);
			$table->boolean('free_shipping')->default(0);
			$table->string('product_ids', 191);
			$table->boolean('ordered_source')->default(1)->comment('1: Website, 2: App');
			$table->string('delivery_phone', 30);
			$table->string('billing_phone', 30);
			$table->text('transaction_id')->nullable();
			$table->timestamps();
			$table->string('delivery_time', 191);
			$table->string('delivery_latitude', 191)->nullable();
			$table->string('delivery_longitude', 191)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}

}
