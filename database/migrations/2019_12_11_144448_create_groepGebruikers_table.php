<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroepGebruikersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groepGebruikers', function(Blueprint $table)
		{
			$table->integer('gebruiker_id');
			$table->integer('groep_id')->index('GroepID');
			$table->timestamps();
			$table->primary(['gebruiker_id','groep_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('groepGebruikers');
	}

}
