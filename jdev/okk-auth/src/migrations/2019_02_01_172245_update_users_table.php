<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('email');
            $table->dropColumn('email_verified_at');
            $table->dropColumn('password');
            $table->dropColumn('remember_token');
            $table->dropTimestamps();

        });
		Schema::table('users', function(Blueprint $table)
		{
			$table->integer('ext_id')->unsigned();
			$table->string('first_name', 256);
			$table->string('last_name', 256);
			$table->string('middle_name', 256)->nullable();
			$table->date('birthday')->nullable();
			$table->string('inn', 15);
			$table->string('passport', 15);
			$table->boolean('gender');
			$table->boolean('banned')->default(0);
			$table->string('remember_token', 100)->nullable();
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
