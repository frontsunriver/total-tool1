<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alert_settings', function(Blueprint $table)
		{
			$table->integer('alert_id', true);
			$table->boolean('create_customer_email')->default(0);
			$table->boolean('create_customer_notification')->default(0);
			$table->boolean('order_status_email')->default(0);
			$table->boolean('order_status_notification')->default(0);
			$table->boolean('new_product_email')->default(0);
			$table->boolean('new_product_notification')->default(0);
			$table->boolean('forgot_email')->default(0);
			$table->boolean('forgot_notification')->default(0);
			$table->boolean('news_email')->default(0);
			$table->boolean('news_notification')->default(0);
			$table->boolean('contact_us_email')->default(0);
			$table->boolean('contact_us_notification')->default(0);
			$table->boolean('order_email')->default(0);
			$table->boolean('order_notification')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('alert_settings');
	}

}
