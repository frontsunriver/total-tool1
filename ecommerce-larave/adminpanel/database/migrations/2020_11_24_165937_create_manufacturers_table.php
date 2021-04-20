<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufacturersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manufacturers', function(Blueprint $table)
		{
			$table->increments('manufacturers_id');
			$table->string('manufacturer_name', 191);
			$table->text('manufacturer_image')->nullable();
			$table->string('manufacturers_slug', 191);
			$table->string('date_added', 191)->nullable();
			$table->string('last_modified', 191)->nullable();
			$table->string('manufacturers_image', 191)->nullable();
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
		Schema::drop('manufacturers');
	}

}
