<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fields', function(Blueprint $table)
		{
			$table->increments('unique_field_id')->unique();
			$table->integer('user_id', false, true)->length(10);
			$table->string('AWDN_id', 7)->nullable()->default(NULL);
			$table->integer('rain_gauge_number', false, true)->length(11)->default(NULL);
			$table->string('field_name', 30)->nullable()->default(NULL);
			$table->string('lat_long_elev', 50)->nullable()->default(NULL);
			$table->float('area', 12, 3)->unsigned()->nullable()->default(0);
			$table->float('wth_Stn_dist', 8, 3)->unsigned()->nullable()->default(0);
			$table->date('field_creation_date')->nullable()->default(NULL);
			$table->string('current_crop', 5)->nullable()->default('S/C');
			$table->tinyInteger('field_status')->nullable()->default(1);
			$table->tinyInteger('days_to_water_stress')->nullable()->default(NULL);
			$table->string('stress_message', 20)->nullable()->default(NULL);
			$table->dateTime('last_sim')->nullable()->default(NULL);
			$table->dateTime('last_update')->nullable()->default(NULL);

			$table->foreign('user_id')
				  ->references('id')
				  ->on('users')
				  ->onDelete('no action')
				  ->onUpdate('no action');

//			$table->foreign(array('uniqueFieldId', 'membersId'))
//				  ->references(array('uniqueFieldId', 'membersId'))
//				  ->on('crops')
//				  ->onDelete('no action')
//				  ->onUpdate('no action');

			$table->foreign('rain_gauge_number')
				  ->references('rain_gauge_number')
				  ->on('rainfalls')
				  ->onDelete('no action')
				  ->onUpdate('no action');

			$table->foreign('AWDN_id')
				  ->references('AWDN_id')
				  ->on('weather_stations')
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
		Schema::drop('fields');
	}

}
