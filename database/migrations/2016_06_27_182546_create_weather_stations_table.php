<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherStationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('weather_stations', function(Blueprint $table)
		{
//			$table->increments('id');
			$table->string('AWDN_id', 7);
			$table->string('stn_name', 20)->nullable()->default(NULL);
			$table->string('stn_lat', 10)->nullable()->default(NULL);
  			$table->string('stn_long',10)->nullable()->default(NULL);
	  		$table->date('stn_start_date')->nullable()->default(NULL);
		  	$table->date('stn_end_date')->nullable()->default('9999-12-31');
  			$table->string('stn_elev', 10)->nullable()->default(NULL);
			$table->string('stn_status', 45)->nullable()->default('1');
  			$table->string('stn_state', 45)->nullable()->default('NE');
		  	$table->string('stn_data_source', 45)->nullable()->default('AWDN');

			$table->primary('AWDN_id');
			$table->unique('AWDN_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('weatherStations');
	}

}
