<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstantBannersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('constant_banners', function(Blueprint $table)
		{
			$table->integer('banners_id', true);
			$table->string('banners_title', 191);
			$table->text('banners_url');
			$table->text('banners_image');
			$table->dateTime('date_added');
			$table->boolean('status')->default(0);
			$table->integer('languages_id');
			$table->string('type', 55);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('constant_banners');
	}

}
