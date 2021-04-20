<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_description', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('payment_methods_id');
			$table->string('name', 100);
			$table->integer('language_id');
			$table->string('sub_name_1', 100);
			$table->string('sub_name_2', 100);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('payment_description');
	}

}
