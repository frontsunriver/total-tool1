<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news', function(Blueprint $table)
		{
			$table->integer('news_id', true);
			$table->text('news_image')->nullable();
			$table->dateTime('news_date_added')->index('idx_products_date_added');
			$table->dateTime('news_last_modified')->nullable();
			$table->boolean('news_status');
			$table->boolean('is_feature')->default(0);
			$table->string('news_slug', 191);
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
		Schema::drop('news');
	}

}
