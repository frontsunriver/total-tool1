<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news_description', function(Blueprint $table)
		{
			$table->integer('language_id')->default(1);
			$table->string('news_name', 64)->default('')->index('products_name');
			$table->integer('news_id');
			$table->text('news_description')->nullable();
			$table->string('news_url', 191)->nullable();
			$table->integer('news_viewed')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('news_description');
	}

}
