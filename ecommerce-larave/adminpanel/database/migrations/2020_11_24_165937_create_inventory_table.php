<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventory', function(Blueprint $table)
		{
			$table->integer('inventory_ref_id', true);
			$table->integer('admin_id');
			$table->integer('added_date');
			$table->string('reference_code', 191)->nullable();
			$table->integer('stock');
			$table->integer('products_id');
			$table->decimal('purchase_price', 10)->nullable();
			$table->string('stock_type', 10);
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
		Schema::drop('inventory');
	}

}
