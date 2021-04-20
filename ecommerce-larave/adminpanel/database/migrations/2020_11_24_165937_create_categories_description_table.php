<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories_description', function(Blueprint $table)
		{
			$table->integer('categories_description_id', true);
			$table->integer('categories_id')->default(0);
			$table->integer('language_id')->default(1);
			$table->string('categories_name', 32)->index('idx_categories_name');
			$table->text('categories_description')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('categories_description');
	}

}
