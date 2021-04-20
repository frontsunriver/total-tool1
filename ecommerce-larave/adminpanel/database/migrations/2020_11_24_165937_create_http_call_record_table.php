<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHttpCallRecordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('http_call_record', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('device_id', 191)->nullable();
			$table->string('ip', 191)->nullable();
			$table->string('url', 191)->nullable();
			$table->dateTime('ping_time')->nullable();
			$table->dateTime('difference_from_previous')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('http_call_record');
	}

}
