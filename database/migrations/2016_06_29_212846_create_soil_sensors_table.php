<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoilSensorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('soil_sensors', function(Blueprint $table)
		{
			$table->increments('sensor_id');
			$table->integer('field_id', false, true)->length(10);
			$table->string('location_lat');
			$table->string('location_long');

			$table->foreign('field_id')
				->references('unique_field_id')
				->on('fields')
				->onDelete('no action')
				->onUpdate('no action');

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
		Schema::drop('soil_sensors');
	}

}
