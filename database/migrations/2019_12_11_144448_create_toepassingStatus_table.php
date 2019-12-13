<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateToepassingStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('toepassingStatus', function(Blueprint $table)
		{
			$table->integer('gebruiker_id');
			$table->integer('toepassing_id')->index('toepassingID');
			$table->boolean('isActief')->default(0);
			$table->timestamps();
			$table->primary(['gebruiker_id','toepassing_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('toepassingStatus');
	}

}
