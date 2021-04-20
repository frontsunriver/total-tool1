<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->integer('products_id', true);
			$table->integer('products_quantity');
			$table->string('products_model', 191)->nullable()->index('idx_products_model');
			$table->text('products_image')->nullable();
			$table->text('products_video_link')->nullable();
			$table->decimal('products_price', 15);
			$table->dateTime('products_date_added')->index('idx_products_date_added');
			$table->dateTime('products_last_modified')->nullable();
			$table->dateTime('products_date_available')->nullable();
			$table->string('products_weight', 191)->nullable();
			$table->string('products_weight_unit', 191)->nullable();
			$table->boolean('products_status');
			$table->boolean('is_current');
			$table->integer('products_tax_class_id');
			$table->integer('manufacturers_id')->nullable();
			$table->integer('products_ordered')->default(0);
			$table->integer('products_liked');
			$table->integer('low_limit');
			$table->boolean('is_feature')->default(0);
			$table->string('products_slug', 191);
			$table->integer('products_type')->default(0);
			$table->integer('products_min_order')->default(1);
			$table->integer('products_max_stock')->nullable();
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
		Schema::drop('products');
	}

}
