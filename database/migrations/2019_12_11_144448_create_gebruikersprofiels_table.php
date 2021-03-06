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
			$table->integer('id', true)->unsigned();
			$table->string('naam')->nullable();
			$table->string('organogram_naam')->nullable();
			$table->integer('team_id')->nullable()->index()->unsigned();
			$table->timestamps();
			$table->softDeletes();
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
