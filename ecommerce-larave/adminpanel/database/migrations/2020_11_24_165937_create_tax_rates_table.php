<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxRatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tax_rates', function(Blueprint $table)
		{
			$table->integer('tax_rates_id', true);
			$table->integer('tax_zone_id');
			$table->integer('tax_class_id');
			$table->integer('tax_priority')->nullable()->default(1);
			$table->decimal('tax_rate', 7);
			$table->string('tax_description', 191);
			$table->dateTime('last_modified')->nullable();
			$table->dateTime('date_added');
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
		Schema::drop('tax_rates');
	}

}
