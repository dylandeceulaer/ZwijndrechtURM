<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGebruikersprofielsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gebruikersprofiels', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('naam')->nullable();
			$table->integer('dienst_id')->nullable()->index('dienstID');
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
		Schema::drop('gebruikersprofiels');
	}

}
