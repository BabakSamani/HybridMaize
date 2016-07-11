<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorDatasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sensor_data', function(Blueprint $table)
		{
			$table->increments('sensor_data_id');
			$table->integer('sensor_id', false, true)->length(10);
			$table->float('depth');
			$table->float('soil_temp');
			$table->float('soil_moisture');
			$table->float('soil_PH');
			$table->float('nitrogen');

			$table->foreign('sensor_id')
				->references('sensor_id')
				->on('soil_sensors')
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
		Schema::drop('sensor_datas');
	}

}
