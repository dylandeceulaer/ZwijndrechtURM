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
			$table->integer('id', true)->unsigned();
			$table->integer('taaksoort_id')->nullable()->index()->unsigned();
			$table->integer('verantwoordelijke')->nullable()->index()->unsigned();
			$table->integer('gebruiker_id')->nullable()->index()->unsigned();
			$table->boolean('isCompleet')->nullable();
			$table->softDeletes();
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
