<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDienstsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('diensts', function(Blueprint $table)
		{
			$table->foreign('diensthoofd_id', 'diensts_ibfk_1')->references('id')->on('gebruikers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('diensts', function(Blueprint $table)
		{
			$table->dropForeign('diensts_ibfk_1');
		});
	}

}
