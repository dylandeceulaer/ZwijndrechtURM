<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleGebruikerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_gebruiker', function (Blueprint $table) {
            $table->integer('role_id')->unsigned()->index();
			$table->integer('gebruiker_id')->unsigned()->index();
            $table->primary(['gebruiker_id','role_id']);
            $table->foreign('gebruiker_id')->references('id')->on('gebruikers')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_gebruiker');
    }
}
