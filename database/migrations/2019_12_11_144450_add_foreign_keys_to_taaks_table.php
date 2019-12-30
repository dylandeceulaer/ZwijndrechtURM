<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTaaksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('taaks', function(Blueprint $table)
		{
			$table->foreign('taaksoort_id', 'taaks_ibfk_1')->references('id')->on('taaksoorts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('verantwoordelijke', 'taaks_ibfk_2')->references('id')->on('gebruikers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('gebruiker_id', 'taaks_ibfk_3')->references('id')->on('gebruikers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('taaks', function(Blueprint $table)
		{
			$table->dropForeign('taaks_ibfk_1');
			$table->dropForeign('taaks_ibfk_2');
			$table->dropForeign('taaks_ibfk_3');
		});
	}

}
