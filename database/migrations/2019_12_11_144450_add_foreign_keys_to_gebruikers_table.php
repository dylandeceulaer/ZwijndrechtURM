<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGebruikersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('gebruikers', function(Blueprint $table)
		{
			$table->foreign('gebruikersprofiel_id', 'gebruiker_ibfk_1')->references('id')->on('gebruikersprofiels')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('role_id', 'gebruiker_ibfk_2')->references('id')->on('roles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('gebruikers', function(Blueprint $table)
		{
			$table->dropForeign('gebruiker_ibfk_1');
			$table->dropForeign('gebruiker_ibfk_2');
		});
	}

}
