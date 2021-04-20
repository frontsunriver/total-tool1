<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bank_detail', function(Blueprint $table)
		{
			$table->integer('bank_detail_id', true);
			$table->string('bank_name', 191);
			$table->string('bank_account_number', 191);
			$table->string('bank_routing_number', 191);
			$table->string('bank_address', 191);
			$table->string('bank_iban', 191);
			$table->string('bank_swift', 191);
			$table->integer('users_id');
			$table->boolean('is_current')->default(0);
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
		Schema::drop('bank_detail');
	}

}
