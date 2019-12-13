<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMutatatiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mutataties', function(Blueprint $table)
		{
			$table->integer('gebruiker_id');
			$table->integer('toepassing_id')->index('toepassingID');
			$table->string('meerInfo')->nullable();
			$table->boolean('isRecht')->nullable();
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
		Schema::drop('mutataties');
	}

}
