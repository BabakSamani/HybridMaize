<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIrrigationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('irrigations', function(Blueprint $table)
		{
			$table->increments('irrigation_records_id');
			// In order to have 3 primary key, autoincrement has to be set to false for this column ('idIrrigationRecords')
			// therefore in the code we need to insert the value of this column every time we make a new record
//			$table->bigInteger('idIrrigationRecords', false, true)->length(10);
			$table->integer('unique_field_id', false, true)->length(10);
			$table->integer('user_id', false, true)->length(10);
			$table->date('irrigation_date');
			$table->float('irrigation_amount')->unsigned()->defualt('0');

//			$table->primary('idIrrigationRecords');
//			$table->primary(array('idIrrigationRecords', 'uniqueFieldId', 'membersId'));

			$table->foreign('unique_field_id')
				->references('unique_field_id')
				->on('fields')
				->onDelete('no action')
				->onUpdate('no action');

//			$table->foreign(array('uniqueFieldId', 'membersId'))
//				  ->references(array('uniqueFieldId', 'membersId'))
//				  ->on('fields')
//				  ->onDelete('no action')
//				  ->onUpdate('no action');

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
		Schema::drop('irrigations');
	}

}
