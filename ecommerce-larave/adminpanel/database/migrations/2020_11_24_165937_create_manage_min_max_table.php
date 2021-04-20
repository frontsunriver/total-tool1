<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManageMinMaxTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manage_min_max', function(Blueprint $table)
		{
			$table->integer('min_max_id', true);
			$table->integer('min_level');
			$table->integer('max_level');
			$table->integer('products_id');
			$table->string('inventory_ref_id', 191);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('manage_min_max');
	}

}
