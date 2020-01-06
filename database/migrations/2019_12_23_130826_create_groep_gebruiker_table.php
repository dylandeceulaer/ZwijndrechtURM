<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroepGebruikerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groep_gebruiker', function (Blueprint $table) {
            $table->integer('groep_id')->index()->unsigned();
            $table->integer('gebruiker_id')->index()->unsigned();
            $table->primary(['groep_id','gebruiker_id']);
            $table->foreign('groep_id')->references('id')->on('groeps')->onDelete('cascade');
            $table->foreign('gebruiker_id')->references('id')->on('gebruikers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_gebruikers');
    }
}
