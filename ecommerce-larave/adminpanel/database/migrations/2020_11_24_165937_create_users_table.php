<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('role_id')->nullable();
			$table->string('user_name', 191)->nullable();
			$table->string('first_name', 191);
			$table->string('last_name', 191);
			$table->string('gender', 191)->nullable();
			$table->integer('default_address_id')->default(0);
			$table->string('country_code', 191)->nullable();
			$table->string('phone', 191)->nullable();
			$table->string('email', 191);
			$table->string('password', 191);
			$table->string('avatar', 191)->nullable();
			$table->string('status', 191)->default('1');
			$table->boolean('is_seen')->default(0);
			$table->boolean('phone_verified')->default(0);
			$table->string('remember_token', 191)->nullable();
			$table->string('auth_id_tiwilo', 191)->nullable();
			$table->string('dob', 33)->nullable();
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
		Schema::drop('users');
	}

}
