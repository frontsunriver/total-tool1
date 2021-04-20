<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxClassTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tax_class', function(Blueprint $table)
		{
			$table->integer('tax_class_id', true);
			$table->string('tax_class_title', 32);
			$table->text('tax_class_description')->nullable();
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
		Schema::drop('tax_class');
	}

}
