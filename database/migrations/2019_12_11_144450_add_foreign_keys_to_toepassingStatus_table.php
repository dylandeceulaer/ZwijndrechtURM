<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToToepassingStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('toepassingStatus', function(Blueprint $table)
		{
			$table->foreign('gebruiker_id', 'toepassingStatus_ibfk_1')->references('id')->on('gebruikers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('toepassing_id', 'toepassingStatus_ibfk_2')->references('id')->on('toepassings')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('toepassingStatus', function(Blueprint $table)
		{
			$table->dropForeign('toepassingStatus_ibfk_1');
			$table->dropForeign('toepassingStatus_ibfk_2');
		});
	}

}
