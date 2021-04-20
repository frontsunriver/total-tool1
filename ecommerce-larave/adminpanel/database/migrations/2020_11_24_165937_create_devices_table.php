<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('devices', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('device_id');
			$table->integer('user_id')->default(0);
			$table->integer('device_type')->default(1);
			$table->boolean('status')->default(0);
			$table->string('ram', 250)->nullable();
			$table->string('processor', 250)->nullable();
			$table->string('device_os', 250)->nullable();
			$table->string('location', 250)->nullable();
			$table->string('latittude', 100)->nullable();
			$table->string('longitude', 100)->nullable();
			$table->string('device_model', 191)->nullable();
			$table->string('manufacturer', 100)->nullable();
			$table->string('operating_system', 100)->nullable();
			$table->string('browser_info', 100)->nullable();
			$table->boolean('is_notify')->default(1);
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
		Schema::drop('devices');
	}

}
