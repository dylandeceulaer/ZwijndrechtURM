<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDienstsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('diensts', function(Blueprint $table)
		{
			$table->integer('id', true)->unsigned();
			$table->string('naam')->nullable();
			$table->integer('diensthoofd')->nullable()->index()->unsigned();
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
		Schema::drop('diensts');
	}

}
