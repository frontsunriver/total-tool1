<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('currencies', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title', 32);
			$table->char('code', 3)->index('idx_currencies_code');
			$table->string('symbol_left', 12)->nullable();
			$table->string('symbol_right', 12)->nullable();
			$table->char('decimal_point', 1)->nullable();
			$table->char('thousands_point', 1)->nullable();
			$table->char('decimal_places', 1)->nullable();
			$table->timestamps();
			$table->float('value', 13, 8)->nullable();
			$table->boolean('is_default')->default(0);
			$table->boolean('status')->default(1);
			$table->boolean('is_current')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('currencies');
	}

}
