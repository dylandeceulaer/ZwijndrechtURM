<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGebruikersprofielsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('gebruikersprofiels', function(Blueprint $table)
		{
			$table->foreign('dienst_id', 'gebruikersprofiels_ibfk_1')->references('id')->on('diensts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('gebruikersprofiels', function(Blueprint $table)
		{
			$table->dropForeign('gebruikersprofiels_ibfk_1');
		});
	}

}
