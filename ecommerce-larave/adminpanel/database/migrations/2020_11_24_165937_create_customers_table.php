<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table)
		{
			$table->integer('customers_id', true);
			$table->integer('user_id')->unsigned();
			$table->string('customers_fax', 191)->nullable();
			$table->string('customers_newsletter', 191)->nullable();
			$table->string('fb_id', 191)->nullable();
			$table->string('google_id', 191)->nullable();
			$table->integer('auth_id_tiwilo')->nullable();
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
		Schema::drop('customers');
	}

}
