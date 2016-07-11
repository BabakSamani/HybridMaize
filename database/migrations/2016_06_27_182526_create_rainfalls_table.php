<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRainfallsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rainfalls', function(Blueprint $table)
		{
//			$table->increments('id');
			$table->integer('user_id', false, true)->length(10);
			$table->integer('rain_gauge_number', false, true)->length(11);
			$table->date('rainfall_date');
			$table->float('rainfall_amount')->defualt('0');

			$table->foreign('user_id')
				  ->references('id')
				  ->on('users')
				  ->onDelete('no action')
				  ->onUpdate('no action');

			$table->primary(array('rain_gauge_number', 'rainfall_date'));

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
		Schema::drop('rainfalls');
	}

}
