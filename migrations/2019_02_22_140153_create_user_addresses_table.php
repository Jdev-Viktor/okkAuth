<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_addresses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('user_addresses_user_id_foreign');
			$table->string('type');
			$table->string('country')->nullable();
			$table->string('country_code')->nullable();
			$table->string('state')->nullable();
			$table->string('city')->nullable();
			$table->string('district')->nullable();
			$table->string('street')->nullable();
			$table->string('building')->nullable();
			$table->string('apartment')->nullable();
			$table->string('postcode')->nullable();
			$table->string('lat')->nullable();
			$table->string('lon')->nullable();
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
		Schema::drop('user_addresses');
	}

}
