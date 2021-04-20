<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrontEndThemeContentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('front_end_theme_content', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('top_offers');
			$table->text('headers');
			$table->text('carousels');
			$table->text('banners');
			$table->text('footers');
			$table->text('product_section_order');
			$table->text('cart');
			$table->text('news');
			$table->text('detail');
			$table->text('shop');
			$table->text('contact');
			$table->text('login');
			$table->text('transitions');
			$table->text('banners_two');
			$table->text('category');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('front_end_theme_content');
	}

}
