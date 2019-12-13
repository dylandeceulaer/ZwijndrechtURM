<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGebruikersprofielToepassingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gebruikersprofielToepassings', function(Blueprint $table)
		{
			$table->integer('toepassing_id');
			$table->integer('gebruikersprofiel_id')->index('gebruikersprofielID');
			$table->string('meerInfo');
			$table->timestamps();
			$table->primary(['toepassing_id','gebruikersprofiel_id'],'gebruikersprofielToepassingen_primary');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gebruikersprofielToepassings');
	}

}
