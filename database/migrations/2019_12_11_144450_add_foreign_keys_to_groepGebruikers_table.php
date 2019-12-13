<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGroepGebruikersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('groepGebruikers', function(Blueprint $table)
		{
			$table->foreign('gebruiker_id', 'groepGebruikers_ibfk_1')->references('id')->on('gebruikers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('groep_id', 'groepGebruikers_ibfk_2')->references('id')->on('groeps')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('groepGebruikers', function(Blueprint $table)
		{
			$table->dropForeign('groepGebruikers_ibfk_1');
			$table->dropForeign('groepGebruikers_ibfk_2');
		});
	}

}
