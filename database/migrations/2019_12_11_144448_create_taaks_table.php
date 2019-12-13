<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaaksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taaks', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('taakSoort_id')->nullable()->index('taakSoortID');
			$table->integer('verantwoordelijke')->nullable()->index('Verantwoordelijke');
			$table->integer('gebruiker_id')->nullable()->index('gebruikerID');
			$table->boolean('isCompleet')->nullable();
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
		Schema::drop('taaks');
	}

}
