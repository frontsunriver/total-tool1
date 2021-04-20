<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('countries', function(Blueprint $table)
		{
			$table->increments('countries_id');
			$table->string('countries_name', 100);
			$table->char('countries_iso_code_3', 3)->nullable();
			$table->char('countries_iso_code_2', 2)->nullable();
			$table->string('country_code')->nullable();
			$table->timestamps();
			$table->boolean('address_format_id')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('countries');
	}

}
