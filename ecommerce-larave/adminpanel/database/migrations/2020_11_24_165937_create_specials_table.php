<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('specials', function(Blueprint $table)
		{
			$table->integer('specials_id', true);
			$table->integer('products_id')->index('idx_specials_products_id');
			$table->decimal('specials_new_products_price', 15);
			$table->integer('specials_date_added');
			$table->integer('specials_last_modified');
			$table->integer('expires_date');
			$table->integer('date_status_change');
			$table->integer('status')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('specials');
	}

}
