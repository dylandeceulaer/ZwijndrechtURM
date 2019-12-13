<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMutatatiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mutataties', function(Blueprint $table)
		{
			$table->foreign('gebruiker_id', 'mutataties_ibfk_1')->references('id')->on('gebruikers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('toepassing_id', 'mutataties_ibfk_2')->references('id')->on('toepassings')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('mutataties', function(Blueprint $table)
		{
			$table->dropForeign('mutataties_ibfk_1');
			$table->dropForeign('mutataties_ibfk_2');
		});
	}

}
