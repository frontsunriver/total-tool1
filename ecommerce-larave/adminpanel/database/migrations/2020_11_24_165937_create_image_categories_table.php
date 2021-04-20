<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('image_categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('image_id')->unsigned();
			$table->enum('image_type', array('ACTUAL','THUMBNAIL','LARGE','MEDIUM'));
			$table->integer('height');
			$table->integer('width');
			$table->string('path', 191);
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
		Schema::drop('image_categories');
	}

}
