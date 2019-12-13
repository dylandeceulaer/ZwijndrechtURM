<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToToepassingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('toepassings', function(Blueprint $table)
		{
			$table->foreign('toepassingsverantwoordelijke', 'toepassings_ibfk_1')->references('id')->on('groeps')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('toepassingSoort_id', 'toepassings_ibfk_2')->references('id')->on('toepassingSoorts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('toepassings', function(Blueprint $table)
		{
			$table->dropForeign('toepassings_ibfk_1');
			$table->dropForeign('toepassings_ibfk_2');
		});
	}

}
