<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressBookTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('address_book', function(Blueprint $table)
		{
			$table->integer('address_book_id', true);
			$table->integer('user_id')->index('idx_address_book_customers_id');
			$table->char('entry_gender', 1)->nullable();
			$table->integer('customers_id')->nullable();
			$table->string('entry_company', 191)->nullable();
			$table->string('entry_firstname', 191);
			$table->string('entry_lastname', 191);
			$table->string('entry_street_address', 191);
			$table->string('entry_suburb', 191)->nullable();
			$table->string('entry_postcode', 191);
			$table->string('entry_city', 191);
			$table->string('entry_state', 191)->nullable();
			$table->integer('entry_country_id')->default(0);
			$table->integer('entry_zone_id')->default(0);
			$table->string('entry_latitude', 100)->nullable();
			$table->string('entry_longitude', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('address_book');
	}

}
