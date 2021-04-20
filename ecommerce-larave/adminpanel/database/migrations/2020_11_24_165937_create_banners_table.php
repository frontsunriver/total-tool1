<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banners', function(Blueprint $table)
		{
			$table->integer('banners_id', true);
			$table->string('banners_title', 64);
			$table->string('banners_url', 191);
			$table->text('banners_image');
			$table->string('banners_group', 10)->index('idx_banners_group');
			$table->text('banners_html_text')->nullable();
			$table->integer('expires_impressions')->nullable()->default(0);
			$table->dateTime('expires_date')->nullable();
			$table->dateTime('date_scheduled')->nullable();
			$table->dateTime('date_added');
			$table->dateTime('date_status_change')->nullable();
			$table->integer('status')->default(1);
			$table->string('type', 250);
			$table->string('banners_slug', 191);
			$table->timestamps();
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
		Schema::drop('banners');
	}

}
