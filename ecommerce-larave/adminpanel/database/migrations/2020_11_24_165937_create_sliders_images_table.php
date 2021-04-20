<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sliders_images', function(Blueprint $table)
		{
			$table->integer('sliders_id', true);
			$table->string('sliders_title', 64);
			$table->string('sliders_url', 191);
			$table->integer('carousel_id')->nullable();
			$table->string('sliders_image', 191);
			$table->string('sliders_group', 64);
			$table->text('sliders_html_text');
			$table->dateTime('expires_date');
			$table->dateTime('date_added');
			$table->boolean('status');
			$table->string('type', 64);
			$table->dateTime('date_status_change')->nullable();
			$table->integer('languages_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sliders_images');
	}

}
