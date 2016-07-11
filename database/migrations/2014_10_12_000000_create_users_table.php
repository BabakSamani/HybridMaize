<?php

use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
			$table->increments('id')->unique();
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->string('first_name', 45);
			$table->string('last_name', 45);
			$table->string('activation')->nullable()->default(NULL);
			$table->string('status')->nullable()->default(NULL);
			$table->string('phone')->nullable()->default(NULL);
			$table->string('address')->nullable()->default(NULL);
			$table->string('state')->nullable()->default(NULL);
			$table->string('zip_code')->nullable()->default(NULL);
			$table->string('country')->nullable()->default(NULL);
			$table->date('last_login')->nullable()->default(NULL);
			$table->date('acc_creation_date')->nullable()->default(NULL);
			$table->rememberToken();
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
