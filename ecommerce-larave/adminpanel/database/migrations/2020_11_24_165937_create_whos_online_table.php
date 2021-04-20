<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhosOnlineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('whos_online', function(Blueprint $table)
		{
			$table->integer('customer_id')->default(0)->primary();
			$table->string('full_name', 191);
			$table->string('session_id', 128);
			$table->string('ip_address', 15);
			$table->string('time_entry', 14);
			$table->string('time_last_click', 14);
			$table->text('last_page_url');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('whos_online');
	}

}
