<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGebruikersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gebruikers', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('objectguid')->nullable();
			$table->string('naam');
			$table->string('password')->nullable();
			$table->string('email')->nullable();
			$table->string('samaccountname')->nullable();
			$table->dateTime('inDienst')->nullable();
			$table->dateTime('uitDienst')->nullable();
			$table->integer('gebruikersprofiel_id')->nullable()->index('gebruikersprofielID');
			$table->integer('role_id')->nullable()->index('roleId');
			$table->boolean('isTweedeDienst')->default(0);
			$table->boolean('isDeleted')->default(0);
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gebruikers');
	}

}
