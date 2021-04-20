<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingMethodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shipping_methods', function(Blueprint $table)
		{
			$table->integer('shipping_methods_id', true);
			$table->string('methods_type_link', 100);
			$table->boolean('isDefault')->default(0);
			$table->boolean('status')->default(0);
			$table->string('table_name', 191);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shipping_methods');
	}

}
