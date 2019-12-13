<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateToepassingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('toepassings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('naam');
			$table->integer('toepassingsverantwoordelijke')->nullable()->index('toepassingsverantwoordelijke');
			$table->string('beschrijving')->nullable();
			$table->integer('toepassingSoort_id')->nullable()->index('toepassingSoortID');
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
		Schema::drop('toepassings');
	}

}
