<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCropsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('crops', function(Blueprint $table)
		{
			$table->increments('crop_id');
			$table->integer('unique_field_id', false, true)->length(10);
			$table->integer('user_id', false, true)->length(10);
			$table->date('date_of_planting')->nullable()->defualt(NULL);
			$table->string('hyb_rel_mat', 3)->nullable()->defualt(NULL);
			$table->float('plant_population')->unsigned()->nullable()->defualt(NULL);
			$table->integer('soil_rooting_depth', false, true)->length(2)->unsigned()->nullable()->defualt('60');
			$table->integer('soil_surface_residues', false, true)->length(2)->unsigned()->nullable()->defualt('50');
			$table->float('bulk_density')->nullable()->defualt('1.3');
			$table->string('soil_texture_topsoil', 20)->nullable()->defualt(NULL);
			$table->string('soil_texture_subsoil', 20)->nullable()->defualt(NULL);
			$table->string('soil_moisture_topsoil', 20)->nullable()->defualt(NULL);
			$table->string('soil_moisture_subsoil', 20)->nullable()->defualt(NULL);
			$table->string('crop', 5)->nullable()->defualt('S/C');
			$table->date('planting_year')->nullable()->defualt(NULL);

//  			$table->primary(array('uniqueFieldId', 'membersId'));

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
//			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('crops');
	}

}
