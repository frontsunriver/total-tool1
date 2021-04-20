<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeBannersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('home_banners', function(Blueprint $table)
		{
			$table->bigInteger('home_banners_id', true)->unsigned();
			$table->string('banner_name', 191);
			$table->integer('language_id')->default(1);
			$table->text('text')->nullable();
			$table->integer('image')->nullable();
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
		Schema::drop('home_banners');
	}

}
