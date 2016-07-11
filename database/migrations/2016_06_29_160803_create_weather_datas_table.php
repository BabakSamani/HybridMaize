<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherDatasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('weather_data', function(Blueprint $table)
		{
			$table->increments('weather_data_id');
			$table->string('weather_station_id', 7);
			$table->date('date');
			$table->integer('doy', false, true)->length(3)->nullable()->default(NULL);
			$table->float('t_max', 6, 2)->nullable();
			$table->float('t_min', 6, 2)->nullable();
			$table->float('relative_humidity')->nullable();
			$table->float('wind_speed')->nullable();
			$table->float('solar_rad')->nullable();
			$table->float('pre')->nullable();
			$table->float('ET')->nullable();

			$table->foreign('weather_station_id')
				  ->references('AWDN_id')
				  ->on('weather_stations')
				  ->onDelete('no action')
				  ->onUpdate('no action');

			$table->timestamps();
			$table->unique('weather_data_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('weather_data');
	}

}
