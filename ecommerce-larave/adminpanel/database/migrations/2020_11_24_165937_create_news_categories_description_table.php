<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsCategoriesDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news_categories_description', function(Blueprint $table)
		{
			$table->integer('categories_description_id', true);
			$table->integer('categories_id')->default(0);
			$table->integer('language_id')->default(1);
			$table->string('categories_name', 32)->index('idx_categories_name');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('news_categories_description');
	}

}
